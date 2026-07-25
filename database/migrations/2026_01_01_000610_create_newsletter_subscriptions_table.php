<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Lead-magnet signups. Figma: 1419:9322 (Home strip) and the in-article
 * checklist banner on the single-blog page.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_subscriptions', function (Blueprint $table): void {
            $table->id();

            $table->string('email', 200)->unique();
            $table->string('locale', 5);
            $table->string('source', 50)->nullable()->comment('home|article|contact');

            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('unsubscribed_at')->nullable();
            $table->string('unsubscribe_token', 64)->unique();

            $table->string('ip_address', 45)->nullable();

            $table->timestamps();

            $table->index(['unsubscribed_at', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscriptions');
    }
};
