<?php

declare(strict_types=1);

use App\Models\LeadMagnetDelivery;
use App\Models\NewsletterSubscription;
use App\Models\Post;
use App\Models\Page;
use App\Models\PageSection;
use App\Enums\SectionType;
use App\Notifications\LeadMagnetFile;
use Illuminate\Support\Facades\Notification;
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

it('emails the configured file and records a successful delivery', function (): void {
    Storage::fake('local');
    Notification::fake();
    Storage::disk('local')->put('lead-magnets/checklist.pdf', 'pdf contents');
    downloadablePost()->update([
        'lead_magnet_allow_download' => false,
        'lead_magnet_send_email' => true,
    ]);

    $this->post('/en/insights/useful-insight/lead-magnet', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'source' => 'article',
    ])->assertRedirect();

    Notification::assertSentOnDemand(LeadMagnetFile::class);
    expect(LeadMagnetDelivery::query()->first())
        ->email_status->toBe('sent')
        ->response_code->toBe(200)
        ->email_sent_at->not->toBeNull()
        ->download_enabled->toBeFalse();

    $this->get('/en/insights/useful-insight/lead-magnet/download')->assertNotFound();
});

it('logs a download-only request without claiming an email was sent', function (): void {
    Storage::fake('local');
    Notification::fake();
    Storage::disk('local')->put('lead-magnets/checklist.pdf', 'pdf contents');
    downloadablePost();

    $this->post('/en/insights/useful-insight/lead-magnet', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'source' => 'article',
    ]);

    Notification::assertNothingSent();
    expect(LeadMagnetDelivery::query()->first())
        ->email_status->toBe('not_requested')
        ->response_code->toBeNull()
        ->download_enabled->toBeTrue();
});

it('unlocks the file configured on the home-page lead magnet after form submission', function (): void {
    Storage::fake('local');
    Storage::disk('local')->put('lead-magnets/home-checklist.pdf', 'pdf contents');
    $home = Page::factory()->create(['key' => 'home']);
    $section = PageSection::query()->create([
        'sectionable_type' => Page::class,
        'sectionable_id' => $home->getKey(),
        'type' => SectionType::LeadMagnet,
        'sort_order' => 4,
        'is_visible' => true,
        'lead_magnet_file_path' => 'lead-magnets/home-checklist.pdf',
    ]);

    $this->post("/en/home/lead-magnet/{$section->getKey()}", [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'source' => 'home',
    ])->assertRedirect();

    $this->get("/en/home/lead-magnet/{$section->getKey()}/download")
        ->assertOk()
        ->assertDownload('home-checklist.pdf');

    expect(LeadMagnetDelivery::query()->latest('id')->first())
        ->post_id->toBeNull()
        ->page_section_id->toBe($section->getKey());
});
