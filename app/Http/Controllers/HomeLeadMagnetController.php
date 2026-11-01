<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SectionType;
use App\Http\Requests\NewsletterSubscriptionRequest;
use App\Models\LeadMagnetDelivery;
use App\Models\NewsletterSubscription;
use App\Models\Page;
use App\Models\PageSection;
use App\Notifications\LeadMagnetFile;
use App\Services\SubmissionHandler;
use App\Support\MailSettings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

/** Delivers the private file configured on the home-page Lead Magnet block. */
final class HomeLeadMagnetController extends Controller
{
    public function store(NewsletterSubscriptionRequest $request, string $locale, PageSection $section, SubmissionHandler $handler): RedirectResponse
    {
        $this->ensureHomeLeadMagnet($section);
        $path = (string) $section->lead_magnet_file_path;
        abort_if(blank($path) || ! Storage::disk('local')->exists($path)
            || (! $section->lead_magnet_allow_download && ! $section->lead_magnet_send_email), 404);

        $handler->handleNewsletter($request);
        $email = strtolower((string) $request->validated('email'));
        $subscription = NewsletterSubscription::query()->where('email', $email)->first();
        $delivery = LeadMagnetDelivery::create([
            'page_section_id' => $section->getKey(),
            'newsletter_subscription_id' => $subscription?->getKey(),
            'name' => $request->validated('name'),
            'email' => $email,
            'locale' => app()->getLocale(),
            'download_enabled' => $section->lead_magnet_allow_download,
            'email_enabled' => $section->lead_magnet_send_email,
            'email_status' => $section->lead_magnet_send_email ? 'pending' : 'not_requested',
            'ip_address' => $request->ip(),
        ]);

        if ($section->lead_magnet_send_email) {
            try {
                MailSettings::apply();
                Notification::route('mail', $email)->notify(new LeadMagnetFile(
                    (string) $section->getTranslation('title', app()->getLocale()), $path, app()->getLocale(),
                ));
                $delivery->update(['email_status' => 'sent', 'response_code' => 200, 'email_sent_at' => now()]);
            } catch (Throwable $exception) {
                report($exception);
                $delivery->update(['email_status' => 'failed', 'response_code' => 500, 'error_message' => mb_substr($exception->getMessage(), 0, 2000)]);
            }
        }

        if ($section->lead_magnet_allow_download) {
            $request->session()->put($this->sessionKey($section), ['delivery_id' => $delivery->getKey(), 'unlocked_at' => now()->timestamp]);
        }

        return back()->with('lead_magnet', [
            'downloaded' => (bool) $section->lead_magnet_allow_download,
            'emailed' => $delivery->email_status === 'sent',
            'email_failed' => $delivery->email_status === 'failed',
        ]);
    }

    public function download(Request $request, string $locale, PageSection $section): StreamedResponse
    {
        $this->ensureHomeLeadMagnet($section);
        $path = (string) $section->lead_magnet_file_path;
        abort_if(! $section->lead_magnet_allow_download || blank($path) || ! Storage::disk('local')->exists($path), 404);

        $unlock = $request->session()->get($this->sessionKey($section), []);
        abort_if((int) ($unlock['unlocked_at'] ?? 0) < now()->subMinutes(15)->timestamp, 403);
        LeadMagnetDelivery::query()->whereKey($unlock['delivery_id'] ?? null)
            ->where('page_section_id', $section->getKey())->update(['downloaded_at' => now()]);

        return Storage::disk('local')->download($path, basename($path));
    }

    private function ensureHomeLeadMagnet(PageSection $section): void
    {
        abort_unless($section->type === SectionType::LeadMagnet
            && $section->sectionable_type === Page::class
            && $section->sectionable?->key === 'home', 404);
    }

    private function sessionKey(PageSection $section): string
    {
        return 'home_lead_magnet_downloads.'.$section->getKey();
    }
}
