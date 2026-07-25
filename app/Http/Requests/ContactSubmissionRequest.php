<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

/**
 * Contact form. Figma 1363:8934 — name, brand name, phone (+968 default),
 * multi-select services, short message.
 *
 * Spam protection is two-layer and silent:
 *   1. `website` honeypot — hidden field bots fill in
 *   2. `form_started_at` timestamp — submissions faster than 3s are bots
 * Both fail validation with a generic message so a bot learns nothing.
 */
final class ContactSubmissionRequest extends FormRequest
{
    private const MIN_FILL_SECONDS = 3;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:150'],
            'brand_name' => ['nullable', 'string', 'max:150'],

            // Loose on format: the design ships a country picker, and phone
            // formats vary too widely to validate strictly without rejecting
            // legitimate numbers.
            'phone' => ['nullable', 'string', 'min:6', 'max:30', 'regex:/^[\d\s+()\-]+$/'],

            'email' => ['nullable', 'email:rfc,dns', 'max:200'],
            'message' => ['nullable', 'string', 'max:5000'],

            'service_ids' => ['nullable', 'array', 'max:10'],
            'service_ids.*' => ['integer', 'exists:services,id'],

            // Honeypot — must stay empty.
            'website' => ['nullable', 'prohibited'],
            'form_started_at' => ['nullable', 'integer'],
        ];
    }

    /**
     * At least one contact route must be provided, and the timing check runs
     * after the field rules pass.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if (blank($this->input('phone')) && blank($this->input('email'))) {
                $validator->errors()->add(
                    'phone',
                    __('validation.custom.contact.reachable'),
                );
            }

            $startedAt = $this->integer('form_started_at');

            if ($startedAt > 0) {
                $elapsed = now()->timestamp - (int) ($startedAt / 1000);

                if ($elapsed < self::MIN_FILL_SECONDS) {
                    $validator->errors()->add('name', __('validation.custom.contact.too_fast'));
                }
            }
        });
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('forms.contact.name'),
            'brand_name' => __('forms.contact.brand'),
            'phone' => __('forms.contact.phone'),
            'message' => __('forms.contact.message'),
            'service_ids' => __('forms.contact.services'),
        ];
    }

    /**
     * Titles snapshotted at submission time so the record stays readable if a
     * Service is later renamed or removed.
     *
     * @return array<int, string>
     */
    public function serviceTitles(): array
    {
        $ids = $this->validated('service_ids') ?? [];

        if ($ids === []) {
            return [];
        }

        return Service::query()
            ->whereKey($ids)
            ->withTranslations()
            ->get()
            ->map(fn (Service $s): string => (string) $s->getTranslation('title'))
            ->all();
    }
}
