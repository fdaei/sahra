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

    /** Normalize Persian/Arabic numerals before validating localized input. */
    protected function prepareForValidation(): void
    {
        if (! is_string($this->input('phone'))) {
            return;
        }

        $this->merge([
            'phone' => strtr($this->string('phone')->toString(), [
                '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
                '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
                '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
                '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
            ]),
        ]);
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
            /*
             | The public form (Figma 447:790) renders no email input — only
             | Name / Brand / Phone / Services / Message — so in practice this
             | reduces to "phone is required". The email branch is kept because
             | the rule set still accepts an email from non-form callers, but
             | validation.custom.contact.reachable must not promise the visitor
             | an email field they cannot see.
             */
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

    /** @return array<string, string> */
    public function messages(): array
    {
        return [
            'name.required' => __('forms.contact.errors.name_required'),
            'phone.regex' => __('forms.contact.errors.phone_invalid'),
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
