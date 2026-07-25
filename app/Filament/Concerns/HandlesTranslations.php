<?php

declare(strict_types=1);

namespace App\Filament\Concerns;

use App\Filament\Support\TranslatableForm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Mixed into Filament Create/Edit pages for translatable resources.
 *
 * Splits the nested `translations` array off the form data, saves the parent
 * model, then writes the translation rows — all inside one transaction so a
 * failure part-way cannot leave a record without its translations.
 */
trait HandlesTranslations
{
    /** @var array<string, array<string, mixed>> */
    protected array $pendingTranslations = [];

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        [$data, $this->pendingTranslations] = TranslatableForm::split($data);

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        [$data, $this->pendingTranslations] = TranslatableForm::split($data);

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();

        if ($record instanceof Model) {
            $record->loadMissing('translations');

            return TranslatableForm::hydrate($record, $data);
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data): Model {
            $record = static::getModel()::create($data);

            TranslatableForm::persist($record, $this->pendingTranslations);

            return $record;
        });
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return DB::transaction(function () use ($record, $data): Model {
            $record->update($data);

            TranslatableForm::persist($record, $this->pendingTranslations);

            return $record;
        });
    }
}
