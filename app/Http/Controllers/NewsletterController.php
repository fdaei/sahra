<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscriptionRequest;
use App\Services\SubmissionHandler;
use Illuminate\Http\RedirectResponse;

/**
 * Lead-magnet signup endpoint. Figma 1419:9322.
 */
final class NewsletterController extends Controller
{
    public function __construct(
        private readonly SubmissionHandler $handler,
    ) {}

    public function __invoke(NewsletterSubscriptionRequest $request): RedirectResponse
    {
        $wasNew = $this->handler->handleNewsletter($request);

        return back()->with(
            'success',
            $wasNew ? __('forms.newsletter.success') : __('forms.newsletter.already'),
        );
    }
}
