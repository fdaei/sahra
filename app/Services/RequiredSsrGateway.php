<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\SsrUnavailable;
use Inertia\Ssr\HttpGateway;
use Inertia\Ssr\Response;

final class RequiredSsrGateway extends HttpGateway
{
    public function dispatch(array $page): ?Response
    {
        $response = parent::dispatch($page);

        if ($response === null && config('seo.require_ssr')) {
            throw new SsrUnavailable('The SSR renderer is unavailable.');
        }

        return $response;
    }
}
