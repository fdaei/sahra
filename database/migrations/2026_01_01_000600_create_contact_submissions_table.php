<?php

declare(strict_types=1);

use App\Enums\SubmissionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Contact-form submissions. Figma: 1363:8934 (Contact), plus the same form
 * embedded on Home. Fields mirror the design exactly: name, brand name,
 * phone (+968 default), multi-select services, short message.
 *
 * Not translatable — a submission is written once in whatever locale the
 * visitor used; `locale` records which.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_submissions', function (Blueprint $table): void {
            $table->id();

            $table->string('name', 150);
            $table->string('brand_name', 150)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 200)->nullable();
            $table->text('message')->nullable();

            // Snapshot of chosen service titles, so the record stays readable
            // even if a Service is later renamed or removed.
            $table->json('service_ids')->nullable()->comment('array<int>');
            $table->json('service_titles')->nullable()->comment('array<string> snapshot');

            $table->string('status', 20)->default(SubmissionStatus::New->value);
            $table->text('admin_notes')->nullable();

            $table->string('locale', 5);
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('referrer', 500)->nullable();

            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'created_at'], 'contact_submissions_triage_index');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
    }
};
