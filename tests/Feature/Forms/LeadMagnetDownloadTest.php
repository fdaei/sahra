<?php

declare(strict_types=1);

use App\Models\NewsletterSubscription;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

function downloadablePost(string $path = 'lead-magnets/checklist.pdf'): Post
{
    return Post::factory()
        ->published()
        ->withTranslations([
            'en' => [
                'title' => 'Useful insight',
                'slug' => 'useful-insight',
                'content' => '<p>Article</p>[[lead_magnet]]',
            ],
        ])
        ->create(['lead_magnet_file_path' => $path]);
}

it('unlocks and downloads the file configured for an insight after form submission', function (): void {
    Storage::fake('local');
    Storage::disk('local')->put('lead-magnets/checklist.pdf', 'pdf contents');
    downloadablePost();

    $response = $this->from('/en/insights/useful-insight')
        ->post('/en/insights/useful-insight/lead-magnet', [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'source' => 'article',
        ]);

    $response->assertRedirect('/en/insights/useful-insight');
    expect(NewsletterSubscription::query()->where('email', 'jane@example.com')->exists())->toBeTrue();

    $this->get('/en/insights/useful-insight/lead-magnet/download')
        ->assertOk()
        ->assertDownload('checklist.pdf');
});

it('does not expose an insight file before the form is submitted', function (): void {
    Storage::fake('local');
    Storage::disk('local')->put('lead-magnets/checklist.pdf', 'pdf contents');
    downloadablePost();

    $this->get('/en/insights/useful-insight/lead-magnet/download')->assertForbidden();
});
