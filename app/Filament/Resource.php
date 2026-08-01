<?php

declare(strict_types=1);

namespace App\Filament;

use Filament\Resources\Resource as FilamentResource;
use Illuminate\Support\Str;

abstract class Resource extends FilamentResource
{
    public static function getNavigationGroup(): ?string
    {
        $group = parent::getNavigationGroup();

        return $group === null
            ? null
            : __("admin.navigation.groups.{$group}");
    }

    public static function getNavigationLabel(): string
    {
        $label = parent::getNavigationLabel();
        $key = Str::of(class_basename(static::class))
            ->beforeLast('Resource')
            ->snake()
            ->toString();

        return __("admin.navigation.items.{$key}", [], app()->getLocale()) === "admin.navigation.items.{$key}"
            ? $label
            : __("admin.navigation.items.{$key}");
    }

    public static function getModelLabel(): string
    {
        $key = Str::of(class_basename(static::class))
            ->beforeLast('Resource')
            ->snake()
            ->toString();

        $translated = __("admin.models.{$key}");

        return $translated === "admin.models.{$key}"
            ? parent::getModelLabel()
            : $translated;
    }

    public static function getPluralModelLabel(): string
    {
        $key = Str::of(class_basename(static::class))
            ->beforeLast('Resource')
            ->snake()
            ->toString();

        $translated = __("admin.models_plural.{$key}");

        return $translated === "admin.models_plural.{$key}"
            ? parent::getPluralModelLabel()
            : $translated;
    }
}
