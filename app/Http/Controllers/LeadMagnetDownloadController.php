<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscriptionRequest;
use App\Models\Post;
use App\Services\SubmissionHandler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class LeadMagnetDownloadController extends Controller
{
    public function store(
        NewsletterSubscriptionRequest $request,
        string $locale,
        Post $post,
        SubmissionHandler $handler,
    ): RedirectResponse {
        abort_if(blank($post->lead_magnet_file_path), 404);

        $handler->handleNewsletter($request);
        $request->session()->put($this->sessionKey($post), now()->timestamp);

        return back();
    }

    public function download(Request $request, string $locale, Post $post): BinaryFileResponse
    {
        $path = $post->lead_magnet_file_path;
        abort_if(blank($path) || ! Storage::disk('local')->exists($path), 404);

        $unlockedAt = (int) $request->session()->get($this->sessionKey($post), 0);
        abort_if($unlockedAt < now()->subMinutes(15)->timestamp, 403);

        return Storage::disk('local')->download($path, basename($path));
    }

    private function sessionKey(Post $post): string
    {
        return 'lead_magnet_downloads.'.$post->getKey();
    }
}
