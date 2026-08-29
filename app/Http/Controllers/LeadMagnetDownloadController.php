<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscriptionRequest;
use App\Models\LeadMagnetDelivery;
use App\Models\NewsletterSubscription;
use App\Models\Post;
use App\Notifications\LeadMagnetFile;
use App\Services\SubmissionHandler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;

final class LeadMagnetDownloadController extends Controller
{
    public function store(
        NewsletterSubscriptionRequest $request,
        string $locale,
        Post $post,
        SubmissionHandler $handler,
    ): RedirectResponse {
        $path = $post->lead_magnet_file_path;
        abort_if(
            blank($path)
            || ! Storage::disk('local')->exists($path)
            || (! $post->lead_magnet_allow_download && ! $post->lead_magnet_send_email),
            404,
        );

        $handler->handleNewsletter($request);
        $email = strtolower((string) $request->validated('email'));
        $subscription = NewsletterSubscription::query()->where('email', $email)->first();
        $delivery = LeadMagnetDelivery::create([
            'post_id' => $post->getKey(),
            'newsletter_subscription_id' => $subscription?->getKey(),
            'name' => $request->validated('name'),
            'email' => $email,
            'locale' => app()->getLocale(),
            'download_enabled' => $post->lead_magnet_allow_download,
            'email_enabled' => $post->lead_magnet_send_email,
            'email_status' => $post->lead_magnet_send_email ? 'pending' : 'not_requested',
            'ip_address' => $request->ip(),
        ]);

        if ($post->lead_magnet_send_email) {
            try {
                Notification::route('mail', $email)
                    ->notify(new LeadMagnetFile($post, app()->getLocale()));

                $delivery->update([
                    'email_status' => 'sent',
                    'response_code' => 200,
                    'email_sent_at' => now(),
                ]);
            } catch (Throwable $exception) {
                report($exception);
                $delivery->update([
                    'email_status' => 'failed',
                    'response_code' => 500,
                    'error_message' => mb_substr($exception->getMessage(), 0, 2000),
                ]);
            }
        }

        if ($post->lead_magnet_allow_download) {
            $request->session()->put($this->sessionKey($post), [
                'delivery_id' => $delivery->getKey(),
                'unlocked_at' => now()->timestamp,
            ]);
        }

        return back()->with('lead_magnet', [
            'downloaded' => (bool) $post->lead_magnet_allow_download,
            'emailed' => $delivery->email_status === 'sent',
            'email_failed' => $delivery->email_status === 'failed',
        ]);
    }

    public function download(Request $request, string $locale, Post $post): StreamedResponse
    {
        $path = $post->lead_magnet_file_path;
        abort_if(
            ! $post->lead_magnet_allow_download
            || blank($path)
            || ! Storage::disk('local')->exists($path),
            404,
        );

        $unlock = $request->session()->get($this->sessionKey($post), []);
        $unlockedAt = (int) ($unlock['unlocked_at'] ?? 0);
        abort_if($unlockedAt < now()->subMinutes(15)->timestamp, 403);

        LeadMagnetDelivery::query()
            ->whereKey($unlock['delivery_id'] ?? null)
            ->where('post_id', $post->getKey())
            ->update(['downloaded_at' => now()]);

        return Storage::disk('local')->download($path, basename($path));
    }

    private function sessionKey(Post $post): string
    {
        return 'lead_magnet_downloads.'.$post->getKey();
    }
}
