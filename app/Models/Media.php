<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Translations\MediaTranslation;
use App\Support\CanonicalUrl;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * One file in the media library (Filament → Media library).
 *
 * Files uploaded in the library live under `library/`. Files uploaded through
 * a content field elsewhere are indexed by sync() so their alt/SEO data can
 * be edited here too; the owning record still decides their lifetime.
 *
 * The library's alt text is the site-wide fallback: any image rendered
 * through MediaTransformer without its own alt uses altFor($path).
 *
 * Dimensions come from getimagesize(), which needs neither gd nor imagick.
 */
final class Media extends Model
{
    use HasTranslations;

    public const DISK = 'public';

    public const LIBRARY_DIR = 'library';

    public const TYPES = ['image' => 'Image', 'video' => 'Video', 'audio' => 'Audio', 'document' => 'Document'];

    /** Upload whitelist; also what sync() indexes. */
    public const MIMES = [
        'image' => ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/avif', 'image/svg+xml'],
        'video' => ['video/mp4', 'video/webm', 'video/quicktime'],
        'audio' => ['audio/mpeg', 'audio/mp4', 'audio/ogg', 'audio/wav', 'audio/webm'],
        'document' => ['application/pdf', 'application/zip',
            'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'],
    ];

    private const EXTENSIONS = [
        'image' => ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif', 'svg'],
        'video' => ['mp4', 'webm', 'mov'],
        'audio' => ['mp3', 'm4a', 'ogg', 'wav'],
        'document' => ['pdf', 'zip', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'],
    ];

    /** schema.org types an editor may pick; null derives one from `type`. */
    public const SCHEMA_TYPES = [
        'ImageObject' => 'ImageObject (image)',
        'VideoObject' => 'VideoObject (video)',
        'AudioObject' => 'AudioObject (audio)',
        'DigitalDocument' => 'DigitalDocument (file)',
        'MediaObject' => 'MediaObject (generic)',
    ];

    /** Livewire scratch space and SVG icon sets. */
    private const SKIP_DIRS = ['livewire-tmp', 'icons'];

    private const ALT_CACHE = 'media.alt-map.v1';

    protected $table = 'media';

    protected $fillable = [
        'path', 'name', 'mime', 'type', 'size', 'width', 'height', 'duration',
        'poster_path', 'schema_type', 'credit', 'schema_enabled', 'uploaded_by',
    ];

    /** @var array<int, string> */
    protected array $translatable = ['title', 'alt', 'caption', 'description'];

    protected function casts(): array
    {
        return [
            'size' => 'integer', 'width' => 'integer', 'height' => 'integer',
            'duration' => 'integer', 'schema_enabled' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        self::saved(fn () => self::flushAltMap());
        self::deleted(fn () => self::flushAltMap());
    }

    public function translationModel(): string
    {
        return MediaTranslation::class;
    }

    protected function translationForeignKey(): string
    {
        return 'media_id';
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function url(): string
    {
        return self::publicUrl($this->path);
    }

    public static function publicUrl(string $path): string
    {
        $segments = array_map(rawurlencode(...), explode('/', ltrim($path, '/')));

        return Storage::disk(self::DISK)->url(implode('/', $segments));
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    public function isLibraryFile(): bool
    {
        return Str::startsWith($this->path, self::LIBRARY_DIR.'/');
    }

    public function resolvedSchemaType(): string
    {
        return $this->schema_type ?: match ($this->type) {
            'image' => 'ImageObject',
            'video' => 'VideoObject',
            'audio' => 'AudioObject',
            'document' => 'DigitalDocument',
            default => 'MediaObject',
        };
    }

    /**
     * schema.org node for this file in the given locale, or null when the
     * editor switched schema off.
     *
     * @return array<string, mixed>|null
     */
    public function schema(?string $locale = null): ?array
    {
        if (! $this->schema_enabled) {
            return null;
        }

        $locale ??= app()->getLocale();
        $url = self::absolute($this->url());
        $name = $this->getTranslation('title', $locale) ?: pathinfo($this->name, PATHINFO_FILENAME);
        $description = $this->getTranslation('description', $locale) ?: $this->getTranslation('alt', $locale);

        $node = [
            '@context' => 'https://schema.org',
            '@type' => $this->resolvedSchemaType(),
            'contentUrl' => $url,
            'url' => $url,
            'name' => $name,
            'description' => $description,
            'caption' => $this->getTranslation('caption', $locale),
            'encodingFormat' => $this->mime,
            'contentSize' => $this->size ? (string) $this->size : null,
            'width' => $this->width ? (string) $this->width : null,
            'height' => $this->height ? (string) $this->height : null,
            'inLanguage' => config("locales.supported.{$locale}.html_lang"),
            'uploadDate' => $this->created_at?->toIso8601String(),
            'creditText' => $this->credit,
            'copyrightNotice' => $this->credit,
        ];

        if ($this->isVideo()) {
            $node['thumbnailUrl'] = $this->poster_path ? self::absolute(self::publicUrl($this->poster_path)) : null;
            $node['duration'] = $this->duration ? 'PT'.$this->duration.'S' : null;
        }

        return array_filter($node, fn (mixed $v): bool => $v !== null && $v !== '');
    }

    /**
     * Library alt text for a stored path (fallback for fields that have none).
     */
    public static function altFor(?string $path, ?string $locale = null): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        $locale ??= app()->getLocale();
        $map = Cache::rememberForever(self::ALT_CACHE, fn (): array => MediaTranslation::query()
            ->join('media', 'media.id', '=', 'media_translations.media_id')
            ->whereNotNull('media_translations.alt')
            ->where('media_translations.alt', '!=', '')
            ->get(['media.path', 'media_translations.locale', 'media_translations.alt'])
            ->groupBy('path')
            ->map(fn ($rows) => $rows->pluck('alt', 'locale')->all())
            ->all());

        $byLocale = $map[ltrim($path, '/')] ?? null;

        return $byLocale[$locale] ?? $byLocale[config('locales.fallback')] ?? null;
    }

    public static function flushAltMap(): void
    {
        Cache::forget(self::ALT_CACHE);
    }

    public static function typeFor(string $mime, string $path = ''): string
    {
        foreach (self::MIMES as $type => $mimes) {
            if (in_array($mime, $mimes, true)) {
                return $type;
            }
        }
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        foreach (self::EXTENSIONS as $type => $extensions) {
            if (in_array($ext, $extensions, true)) {
                return $type;
            }
        }

        return Str::before($mime, '/') === 'image' ? 'image' : 'document';
    }

    /** @return list<string> */
    public static function allMimes(): array
    {
        return array_merge(...array_values(self::MIMES));
    }

    public static function supportsExtension(string $extension, ?string $type = null): bool
    {
        return in_array($extension, $type === null ? array_merge(...array_values(self::EXTENSIONS)) : self::EXTENSIONS[$type], true);
    }

    /** Create or refresh the row for a file already on the disk. */
    public static function register(string $path, ?int $userId = null): self
    {
        $disk = Storage::disk(self::DISK);
        $mime = (string) ($disk->mimeType($path) ?: 'application/octet-stream');
        $type = self::typeFor($mime, $path);
        $info = $type === 'image' && ! str_ends_with(strtolower($path), '.svg') ? @getimagesize($disk->path($path)) : false;

        $media = self::query()->firstOrNew(['path' => $path]);
        $media->fill([
            'name' => $media->name ?: basename($path),
            'mime' => $mime,
            'type' => $type,
            'size' => (int) $disk->size($path),
            'width' => $info ? $info[0] : null,
            'height' => $info ? $info[1] : null,
        ]);
        if (! $media->exists) {
            $media->uploaded_by = $userId;
        }
        $media->save();

        return $media;
    }

    /**
     * Index every supported file on the disk that is not in the table yet,
     * and drop rows whose file is gone. Throttled unless forced.
     */
    public static function sync(bool $force = false): void
    {
        if (! $force && ! Cache::add('media.sync', true, 60)) {
            return;
        }

        $disk = Storage::disk(self::DISK);
        $known = self::query()->pluck('size', 'path')->all();
        $seen = [];

        foreach ($disk->allFiles() as $path) {
            if (! self::indexable($path)) {
                continue;
            }
            $seen[$path] = true;
            if (! array_key_exists($path, $known) || (int) $known[$path] !== (int) $disk->size($path)) {
                self::register($path);
            }
        }

        $gone = array_diff(array_keys($known), array_keys($seen));
        if ($gone !== []) {
            self::query()->whereIn('path', $gone)->get()->each->delete();
        }
    }

    private static function indexable(string $path): bool
    {
        if (Str::startsWith($path, array_map(fn (string $d): string => "{$d}/", self::SKIP_DIRS))
            || Str::startsWith(basename($path), '.')
            // Old responsive variants were stored beside the original.
            || (! Str::isUlid(basename(dirname($path))) && preg_match('/-\d+w\.[a-z0-9]+$/i', $path))
        ) {
            return false;
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return self::supportsExtension($ext);
    }

    private static function absolute(string $url): string
    {
        return preg_match('~^https?://~i', $url) ? $url : CanonicalUrl::origin().'/'.ltrim($url, '/');
    }
}
