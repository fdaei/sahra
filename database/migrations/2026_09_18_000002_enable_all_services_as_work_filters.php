<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // The orbit services are valid Work filters as well. Keep the update
        // slug-based so it works with existing installations whose IDs differ.
        DB::table('services')
            ->whereIn('id', function ($query): void {
                $query->select('service_id')
                    ->from('service_translations')
                    ->where('locale', 'en')
                    ->whereIn('slug', [
                        'design-systems',
                        'app-design',
                        'brand-strategy',
                        'ui-ux-design',
                        'web-design',
                        'web-app-development',
                        'printing-services',
                        'packaging-design',
                        'pr-campaigns',
                        'video-productions',
                        'data-science',
                        'production-planning',
                        'gtm-strategy',
                        'smm',
                        'product-writing',
                    ]);
            })
            ->update(['show_on_work_page' => true, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('services')
            ->whereIn('id', function ($query): void {
                $query->select('service_id')
                    ->from('service_translations')
                    ->where('locale', 'en')
                    ->whereIn('slug', [
                        'design-systems', 'app-design', 'brand-strategy',
                        'ui-ux-design', 'web-design', 'web-app-development',
                        'printing-services', 'packaging-design', 'pr-campaigns',
                        'video-productions', 'data-science', 'production-planning',
                        'gtm-strategy', 'smm', 'product-writing',
                    ]);
            })
            ->update(['show_on_work_page' => false, 'updated_at' => now()]);
    }
};
