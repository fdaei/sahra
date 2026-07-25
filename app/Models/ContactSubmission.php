<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SubmissionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * A contact-form submission. Figma 1363:8934.
 *
 * Service selections are stored twice on purpose: `service_ids` for filtering
 * and `service_titles` as a snapshot, so the record stays readable if a
 * Service is renamed or soft-deleted afterwards.
 */
final class ContactSubmission extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'brand_name',
        'phone',
        'email',
        'message',
        'service_ids',
        'service_titles',
        'status',
        'admin_notes',
        'locale',
        'ip_address',
        'user_agent',
        'referrer',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'service_ids' => 'array',
            'service_titles' => 'array',
            'status' => SubmissionStatus::class,
            'read_at' => 'datetime',
        ];
    }

    public function scopeUnread($query)
    {
        return $query->where('status', SubmissionStatus::New);
    }

    public function markAsRead(): bool
    {
        if ($this->status !== SubmissionStatus::New) {
            return false;
        }

        $this->status = SubmissionStatus::Read;
        $this->read_at = now();

        return $this->save();
    }

    /**
     * Live Service models for the stored ids (may be fewer if some were deleted).
     */
    public function services(): Collection
    {
        $ids = $this->service_ids ?? [];

        if ($ids === []) {
            return new Collection;
        }

        return Service::query()->whereKey($ids)->withTranslations()->get();
    }
}
