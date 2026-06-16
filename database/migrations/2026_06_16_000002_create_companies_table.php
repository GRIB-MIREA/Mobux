<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('last_parser_run_id')->nullable()->constrained('company_parser_runs')->nullOnDelete();
            $table->string('provider', 100);
            $table->string('external_id')->nullable();
            $table->string('dedupe_key', 64)->unique();
            $table->string('name');
            $table->string('city');
            $table->string('category');
            $table->string('website')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('source_url')->nullable();
            $table->timestamp('first_seen_at')->nullable();
            $table->timestamp('last_seen_at')->nullable();
            $table->json('raw_payload')->nullable();
            $table->timestamps();

            $table->index(['city', 'category']);
            $table->index(['provider', 'external_id']);
            $table->index('website');
            $table->index('updated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
