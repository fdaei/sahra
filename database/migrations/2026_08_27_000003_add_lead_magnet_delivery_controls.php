<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table): void {
            $table->boolean('lead_magnet_allow_download')->default(true)->after('lead_magnet_file_path');
            $table->boolean('lead_magnet_send_email')->default(false)->after('lead_magnet_allow_download');
        });

        Schema::create('lead_magnet_deliveries', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('newsletter_subscription_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name', 200)->nullable();
            $table->string('email', 200);
            $table->string('locale', 5);
            $table->boolean('download_enabled');
            $table->boolean('email_enabled');
            $table->string('email_status', 20)->default('not_requested');
            $table->unsignedSmallInteger('response_code')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamp('downloaded_at')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index(['post_id', 'created_at']);
            $table->index(['email_status', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_magnet_deliveries');

        Schema::table('posts', function (Blueprint $table): void {
            $table->dropColumn(['lead_magnet_allow_download', 'lead_magnet_send_email']);
        });
    }
};
