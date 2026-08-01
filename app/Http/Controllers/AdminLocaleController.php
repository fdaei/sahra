<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class AdminLocaleController extends Controller
{
    public function __invoke(Request $request, string $locale): RedirectResponse
    {
        abort_unless(in_array($locale, ['en', 'fa'], true), 404);

        $request->session()->put('admin_locale', $locale);

        return redirect()->to(url()->previous() ?: '/admin');
    }
}
