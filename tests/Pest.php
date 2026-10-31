<?php

declare(strict_types=1);

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\EmailValidation;
use Egulias\EmailValidator\Validation\RFCValidation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class)->in('Feature');

// Form fixtures use reserved example.com addresses. Validate their syntax
// without relying on external DNS (example.com may have a null MX record).
// Production keeps the existing RFC + DNS validation unchanged.
uses()->beforeEach(function (): void {
    app()->bind(EmailValidator::class, fn () => new class extends EmailValidator
    {
        public function isValid(string $email, EmailValidation $emailValidation)
        {
            if (str_ends_with(strtolower($email), '@example.com')) {
                $emailValidation = new RFCValidation;
            }

            return parent::isValid($email, $emailValidation);
        }
    });
})->in('Feature/Forms');
