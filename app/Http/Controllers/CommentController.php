<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class CommentController extends Controller
{
    public function store(Request $request, string $locale, Post $post): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $post->comments()->create([...$data, 'locale' => $locale]);

        return back()->with('comment_success', true);
    }
}
