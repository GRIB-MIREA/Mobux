<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('company_parser_runs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('requested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('provider', 100);
            $table->string('city');
            $table->string('category');
            $table->unsignedSmallInteger('result_limit')->default(20);
            $table->string('status', 30)->default('queued');
            $table->unsignedInteger('results_count')->default(0);
            $table->unsignedInteger('new_companies_count')->default(0);
            $table->unsignedInteger('updated_companies_count')->default(0);
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['provider', 'city', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_parser_runs');
    }
};
