<?php

declare(strict_types=1);

use App\Filament\Support\TranslatableForm;
use Illuminate\Database\Eloquent\Model;

function translatableModelStub(): Model
{
    return new class extends Model
    {
        /** @var array<string, array<string, mixed>> */
        public array $persistedTranslations = [];

        /** @param  array<string, array<string, mixed>>  $translations */
        public function setTranslations(array $translations): static
        {
            $this->persistedTranslations = $translations;

            return $this;
        }
    };
}

it('does not persist untouched optional locale tabs', function (): void {
    $model = translatableModelStub();

    TranslatableForm::persist($model, [
        'en' => [
            'name' => 'Growth',
            'slug' => 'growth',
        ],
        'fa' => [
            'name' => null,
            'slug' => null,
        ],
        'ar' => [
            'name' => '',
            'slug' => '',
        ],
    ]);

    expect($model->persistedTranslations)->toBe([
        'en' => [
            'name' => 'Growth',
            'slug' => 'growth',
        ],
    ]);
});

it('does nothing when every locale tab is empty', function (): void {
    $model = translatableModelStub();

    TranslatableForm::persist($model, [
        'en' => [
            'name' => null,
            'slug' => null,
        ],
        'fa' => [
            'name' => '',
            'slug' => '',
        ],
    ]);

    expect($model->persistedTranslations)->toBe([]);
});
