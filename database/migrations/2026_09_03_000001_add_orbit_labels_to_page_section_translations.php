<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_section_translations', function (Blueprint $table): void {
            $table->string('orbit_brand_label', 100)->nullable()->after('content');
            $table->string('orbit_product_label', 100)->nullable()->after('orbit_brand_label');
            $table->string('orbit_core_label', 100)->nullable()->after('orbit_product_label');
        });

        $labels = [
            'en' => ['Brand', 'Product', 'Service Mastery'],
            'fa' => ['برند', 'محصول', 'تسلط خدماتی'],
            'ar' => ['العلامة التجارية', 'المنتج', 'إتقان الخدمة'],
        ];

        foreach ($labels as $locale => [$brand, $product, $core]) {
            DB::table('page_section_translations')
                ->where('locale', $locale)
                ->whereIn('page_section_id', function ($query): void {
                    $query->select('id')
                        ->from('page_sections')
                        ->where('type', 'services_cloud');
                })
                ->update([
                    'orbit_brand_label' => $brand,
                    'orbit_product_label' => $product,
                    'orbit_core_label' => $core,
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('page_section_translations', function (Blueprint $table): void {
            $table->dropColumn([
                'orbit_brand_label',
                'orbit_product_label',
                'orbit_core_label',
            ]);
        });
    }
};
