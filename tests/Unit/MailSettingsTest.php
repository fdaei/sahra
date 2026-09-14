<?php

declare(strict_types=1);

use App\Models\Setting;
use App\Support\MailSettings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('applies encrypted admin SMTP settings to the mail configuration', function (): void {
    Setting::updateOrCreate(
        ['key' => 'mail_enabled'],
        ['group' => 'email', 'value' => ['value' => true], 'is_translatable' => false],
    );
    Setting::updateOrCreate(
        ['key' => 'mail_host'],
        ['group' => 'email', 'value' => ['value' => 'smtp.example.com'], 'is_translatable' => false],
    );
    Setting::updateOrCreate(
        ['key' => 'mail_port'],
        ['group' => 'email', 'value' => ['value' => 465], 'is_translatable' => false],
    );
    Setting::updateOrCreate(
        ['key' => 'mail_encryption'],
        ['group' => 'email', 'value' => ['value' => 'ssl'], 'is_translatable' => false],
    );
    Setting::updateOrCreate(
        ['key' => 'mail_username'],
        ['group' => 'email', 'value' => ['value' => 'mailer@example.com'], 'is_translatable' => false],
    );
    Setting::updateOrCreate(
        ['key' => 'mail_password'],
        ['group' => 'email', 'value' => ['value' => MailSettings::encryptPassword('secret')], 'is_translatable' => false],
    );

    MailSettings::apply();

    expect(config('mail.default'))->toBe('smtp')
        ->and(config('mail.mailers.smtp.host'))->toBe('smtp.example.com')
        ->and(config('mail.mailers.smtp.port'))->toBe(465)
        ->and(config('mail.mailers.smtp.encryption'))->toBe('ssl')
        ->and(config('mail.mailers.smtp.username'))->toBe('mailer@example.com')
        ->and(config('mail.mailers.smtp.password'))->toBe('secret');

    $stored = Setting::query()->where('key', 'mail_password')->firstOrFail()->value['value'];

    expect($stored)->not->toBe('secret')
        ->and(Crypt::decryptString(substr($stored, strlen('encrypted:'))))->toBe('secret');
});
