<?php

declare(strict_types=1);

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Setting::query()->updateOrCreate(
            ['key' => 'copyright_name'],
            [
                'group' => 'general',
                'value' => [
                    'en' => 'Sahra',
                    'fa' => 'صحرا',
                    'ar' => 'صحرا',
                ],
                'is_translatable' => true,
            ],
        );
    }

    public function down(): void
    {
        Setting::query()->where('key', 'copyright_name')->delete();
    }
};
