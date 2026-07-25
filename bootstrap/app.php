<?php

declare(strict_types=1);

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RedirectToLocalisedRoute;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->alias([
            'locale'          => SetLocale::class,
            'locale.redirect' => RedirectToLocalisedRoute::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        /*
         | Render 404/403/419/500 through Inertia so error pages keep the site
         | chrome, the active locale, and the RTL/LTR direction.
         |
         | Figma: 404 desktop 1027:2061, mobile 1567:13563.
         */
        $exceptions->respond(function ($response, Throwable $e, Request $request) {
            if ($request->is('admin*') || $request->expectsJson()) {
                return $response;
            }

            $status = $e instanceof HttpExceptionInterface
                ? $e->getStatusCode()
                : $response->getStatusCode();

            if (! in_array($status, [403, 404, 419, 429, 500, 503], true)) {
                return $response;
            }

            if ($status === 419) {
                return back()->with('error', __('errors.session_expired'));
            }

            return inertia('Error', ['status' => $status])
                ->toResponse($request)
                ->setStatusCode($status);
        });
    })
    ->create();
