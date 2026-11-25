<?php

declare(strict_types=1);

namespace App\Filament\Support;

use App\Enums\PageSchemaType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

final class SchemaFields
{
    public static function pageType(): Select
    {
        return Select::make('seo_page_schema_type')
            ->label('Page schema type')
            ->options(PageSchemaType::options())
            ->in(array_keys(PageSchemaType::options()))
            ->placeholder('Use site default')
            ->helperText('Choose the type that accurately describes this page. The selection applies to all languages.')
            ->native(false);
    }

    /** @return array<int, Section> */
    public static function blocks(string $locale): array
    {
        return [
            Section::make('Questions and answers')
                ->description('These questions appear on the page and are included in its structured data.')
                ->collapsed()->schema([
                    Repeater::make("translations.{$locale}.schema_faq_items")
                        ->label('Questions')->schema([
                            TextInput::make('question')->label('Question')->required()->maxLength(500),
                            Textarea::make('answer')->label('Answer')->required()->rows(3),
                        ])->defaultItems(0)->addActionLabel('Add question'),
                ]),
            Section::make('How-to steps')
                ->description('Optional instructions shown on the page and described as HowTo structured data.')
                ->collapsed()->schema([
                    TextInput::make("translations.{$locale}.schema_howto_title")->label('Guide title')->maxLength(200),
                    Repeater::make("translations.{$locale}.schema_howto_steps")
                        ->label('Steps')->schema([
                            TextInput::make('name')->label('Step title')->required()->maxLength(200),
                            Textarea::make('text')->label('Instructions')->required()->rows(3),
                        ])->defaultItems(0)->addActionLabel('Add step'),
                ]),
        ];
    }
}
