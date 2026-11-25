<?php

declare(strict_types=1);

namespace App\Services\Redirects;

use App\Models\Redirect;
use Illuminate\Support\Facades\DB;

final class RedirectCsv
{
    /** @return array{created: int, updated: int, skipped: int} */
    public static function import(string $path, bool $updateExisting = false): array
    {
        $handle = fopen($path, 'rb');
        if ($handle === false) {
            throw new \RuntimeException('Cannot read CSV file.');
        }
        $result = ['created' => 0, 'updated' => 0, 'skipped' => 0];
        try {
            $header = fgetcsv($handle, 0, ',', '"', '');
            if (! is_array($header)) {
                return $result;
            }
            $header = array_map(static fn ($value): string => strtolower(trim((string) preg_replace('/^\xEF\xBB\xBF/', '', (string) $value))), $header);
            $aliases = ['source' => ['source', 'source_path', 'from', 'url', 'old'], 'destination' => ['destination', 'destination_path', 'to', 'target'], 'status' => ['status', 'status_code', 'code'], 'match' => ['match_type', 'match', 'regex'], 'active' => ['active', 'is_active', 'enabled'], 'notes' => ['notes']];
            $positions = [];
            foreach ($aliases as $field => $names) foreach ($names as $name) {
                $position = array_search($name, $header, true);
                if ($position !== false) { $positions[$field] = $position; break; }
            }
            if (! isset($positions['source'])) {
                rewind($handle); $positions = ['source' => 0, 'destination' => 1, 'status' => 2];
            }
            DB::transaction(function () use ($handle, $positions, $updateExisting, &$result): void {
                while (($row = fgetcsv($handle, 0, ',', '"', '')) !== false) {
                    $read = static fn (string $name, string $default = ''): string => trim((string) ($row[$positions[$name] ?? -1] ?? $default));
                    $rawSource = $read('source');
                    $match = in_array(strtolower($read('match')), ['regex', '1', 'true', 'yes'], true) ? 'regex' : 'exact';
                    $source = $match === 'regex' ? $rawSource : Redirect::normalize($rawSource);
                    $rawStatus = $read('status', '301'); $status = ctype_digit($rawStatus) ? (int) $rawStatus : 0;
                    $destination = $read('destination');
                    $isGone = in_array($status, Redirect::GONE, true);
                    $exactMap = Redirect::query()->active()->where('match_type', 'exact')->get(['id', 'source_path', 'destination_path', 'status_code'])
                        ->mapWithKeys(fn (Redirect $r): array => [$r->source_path => [(string) $r->destination_path, (int) $r->status_code, (int) $r->id]])->all();
                    $invalid = $source === '' || mb_strlen($source) > 500 || ! array_key_exists($status, Redirect::STATUSES)
                        || ($match === 'regex' && RegexRedirect::pattern($source) === null)
                        || ($match === 'exact' && (str_starts_with($source, 'admin') || str_starts_with($source, 'livewire')))
                        || (! $isGone && (! RedirectSafety::validDestination($destination) || ($match === 'exact' && RedirectSafety::createsLoop($source, $destination, $exactMap))));
                    if ($invalid) { $result['skipped']++; continue; }
                    $existing = Redirect::query()->where('source_path', $source)->first();
                    if ($existing && ! $updateExisting) { $result['skipped']++; continue; }
                    $attributes = ['destination_path' => $isGone ? null : $destination, 'status_code' => $status, 'match_type' => $match,
                        'is_active' => ! in_array(strtolower($read('active', '1')), ['0', 'false', 'no', 'inactive', 'disabled'], true),
                        'notes' => mb_substr($read('notes'), 0, 500), 'origin' => 'import'];
                    if ($existing) { $existing->update($attributes); $result['updated']++; }
                    else { Redirect::create(['source_path' => $source] + $attributes); $result['created']++; }
                }
            });
        } finally {
            fclose($handle);
        }
        RedirectMap::flush();

        return $result;
    }
}
