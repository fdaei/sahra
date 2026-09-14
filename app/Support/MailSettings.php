<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Mail\MailManager;
use Illuminate\Support\Facades\Crypt;
use Throwable;

/**
 * Applies SMTP settings stored in the admin settings table to Laravel's mail
 * manager. Passwords are encrypted before they are stored in the JSON value.
 */
final class MailSettings
{
    private const PASSWORD_PREFIX = 'encrypted:';

    /** @var array<string, mixed>|null */
    private static ?array $baseSmtp = null;

    /** @var array<string, mixed>|null */
    private static ?array $baseFrom = null;

    private static ?string $baseDefault = null;

    private static ?string $baseContactRecipient = null;

    /**
     * Apply admin-managed SMTP settings, or restore the .env mail defaults when
     * custom SMTP is disabled.
     */
    public static function apply(): void
    {
        self::rememberBaseConfiguration();

        $enabled = (bool) SiteSettings::get('mail_enabled', null, false);
        $host = (string) SiteSettings::get('mail_host', null, '');
        $useCustomSmtp = $enabled && $host !== '';

        $default = $useCustomSmtp ? 'smtp' : self::$baseDefault;
        $smtp = self::$baseSmtp;
        $from = self::$baseFrom;
        $contactRecipient = self::nullableString('mail_contact_notification_address')
            ?: self::$baseContactRecipient;

        if ($useCustomSmtp) {
            $smtp = array_replace($smtp, [
                'transport' => 'smtp',
                'url' => null,
                'host' => $host,
                'port' => (int) SiteSettings::get('mail_port', null, 587),
                'encryption' => self::encryption(),
                'username' => self::nullableString('mail_username'),
                'password' => self::password(),
            ]);

            $from = [
                'address' => self::nullableString('mail_from_address') ?: ($from['address'] ?? null),
                'name' => self::nullableString('mail_from_name') ?: ($from['name'] ?? null),
            ];

        }

        config()->set([
            'mail.default' => $default,
            'mail.mailers.smtp' => $smtp,
            'mail.from' => $from,
            'mail.contact_notification_address' => $contactRecipient,
        ]);

        if (app()->bound('mail.manager')) {
            /** @var MailManager $manager */
            $manager = app('mail.manager');
            $manager->purge('smtp');
            $manager->setDefaultDriver($default);
        }
    }

    public static function encryptPassword(?string $password): ?string
    {
        if ($password === null || $password === '') {
            return null;
        }

        return self::PASSWORD_PREFIX.Crypt::encryptString($password);
    }

    /**
     * Return the stored value unchanged so a blank password field does not
     * erase an existing password during an unrelated settings update.
     */
    public static function storedPassword(): ?string
    {
        $password = SiteSettings::get('mail_password', null, null);

        return is_string($password) && $password !== '' ? $password : null;
    }

    private static function rememberBaseConfiguration(): void
    {
        self::$baseSmtp ??= (array) config('mail.mailers.smtp', []);
        self::$baseFrom ??= (array) config('mail.from', []);
        self::$baseDefault ??= (string) config('mail.env_default', config('mail.default', 'log'));
        self::$baseContactRecipient ??= config('mail.contact_notification_address');
    }

    private static function encryption(): ?string
    {
        $encryption = (string) SiteSettings::get('mail_encryption', null, 'tls');

        return $encryption === 'none' ? null : $encryption;
    }

    private static function password(): ?string
    {
        return self::decryptPassword(self::storedPassword());
    }

    private static function decryptPassword(?string $password): ?string
    {
        if ($password === null || $password === '') {
            return null;
        }

        if (! str_starts_with($password, self::PASSWORD_PREFIX)) {
            // Support values saved before password encryption was introduced.
            return $password;
        }

        try {
            return Crypt::decryptString(substr($password, strlen(self::PASSWORD_PREFIX)));
        } catch (Throwable) {
            return null;
        }
    }

    private static function nullableString(string $key): ?string
    {
        $value = SiteSettings::get($key, null, null);

        return is_string($value) && $value !== '' ? $value : null;
    }
}
