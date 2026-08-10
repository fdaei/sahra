<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Lead-magnet signup. Figma 1419:9322 and the in-article checklist banner.
 *
 * Email is NOT unique-validated: a returning address is resubscribed rather
 * than rejected, which is friendlier and avoids leaking who is on the list.
 */
final class NewsletterSubscriptionRequest extends FormRequest
{
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
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc,dns', 'max:200'],
            'source' => ['nullable', 'string', 'in:home,article,contact'],
            'website' => ['nullable', 'prohibited'], // honeypot
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('forms.newsletter.name'),
            'email' => __('forms.newsletter.email'),
        ];
    }
}
