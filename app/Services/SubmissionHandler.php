<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\SubmissionStatus;
use App\Http\Requests\ContactSubmissionRequest;
use App\Http\Requests\NewsletterSubscriptionRequest;
use App\Models\ContactSubmission;
use App\Models\NewsletterSubscription;
use App\Notifications\ContactSubmissionReceived;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

/**
 * Persists public form submissions and dispatches notifications.
 *
 * Kept out of the controllers so both the Contact page and the Home-embedded
 * form go through identical logic, and so the behaviour is unit-testable
 * without an HTTP round trip.
 */
final class SubmissionHandler
{
    /**
     * Store a contact submission and notify the team.
     */
    public function handleContact(ContactSubmissionRequest $request): ContactSubmission
    {
        $submission = DB::transaction(function () use ($request): ContactSubmission {
            return ContactSubmission::create([
                'name' => $request->validated('name'),
                'brand_name' => $request->validated('brand_name'),
                'phone' => $request->validated('phone'),
                'email' => $request->validated('email'),
                'message' => $request->validated('message'),
                'service_ids' => $request->validated('service_ids') ?? [],
                'service_titles' => $request->serviceTitles(),
                'status' => SubmissionStatus::New,
                'locale' => app()->getLocale(),
                'ip_address' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 500),
                'referrer' => substr((string) $request->header('referer'), 0, 500),
            ]);
        });

        $recipient = config('mail.contact_notification_address');

        if (is_string($recipient) && $recipient !== '') {
            // Queued — the visitor gets their success state immediately.
            Notification::route('mail', $recipient)
                ->notify(new ContactSubmissionReceived($submission));
        }

        return $submission;
    }

    /**
     * Subscribe an address.
     *
     * @return bool  true when newly subscribed, false when already on the list
     */
    public function handleNewsletter(NewsletterSubscriptionRequest $request): bool
    {
        $email = strtolower((string) $request->validated('email'));

        $existing = NewsletterSubscription::query()
            ->where('email', $email)
            ->first();

        if ($existing !== null) {
            $existing->name = $request->validated('name');

            // Previously unsubscribed addresses are quietly reactivated.
            if (! $existing->isActive()) {
                $existing->resubscribe();

                return true;
            }

            $existing->save();

            return false;
        }

        NewsletterSubscription::create([
            'name' => $request->validated('name'),
            'email' => $email,
            'locale' => app()->getLocale(),
            'source' => $request->validated('source') ?? 'home',
            'ip_address' => $request->ip(),
        ]);

        return true;
    }
}
