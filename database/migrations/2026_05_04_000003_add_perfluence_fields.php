<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'perfluence_category_id')) {
                $table->unsignedBigInteger('perfluence_category_id')->nullable()->unique()->after('id');
            }
        });

        Schema::table('cards', function (Blueprint $table) {
            if (!Schema::hasColumn('cards', 'perfluence_project_id')) {
                $table->unsignedBigInteger('perfluence_project_id')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('cards', 'perfluence_site')) {
                $table->string('perfluence_site')->nullable()->after('link');
            }
        });

        Schema::table('promocodes', function (Blueprint $table) {
            if (!Schema::hasColumn('promocodes', 'perfluence_promocode_id')) {
                $table->unsignedBigInteger('perfluence_promocode_id')->nullable()->unique()->after('id');
            }
            if (!Schema::hasColumn('promocodes', 'perfluence_landing_id')) {
                $table->unsignedBigInteger('perfluence_landing_id')->nullable()->index()->after('perfluence_promocode_id');
            }
            if (!Schema::hasColumn('promocodes', 'promo_terms')) {
                $table->text('promo_terms')->nullable()->after('reward');
            }
            if (!Schema::hasColumn('promocodes', 'region_promo')) {
                $table->string('region_promo')->nullable()->after('promo_terms');
            }
            if (!Schema::hasColumn('promocodes', 'is_hit')) {
                $table->boolean('is_hit')->default(false)->after('region_promo');
            }
            if (!Schema::hasColumn('promocodes', 'is_universal')) {
                $table->boolean('is_universal')->default(false)->after('is_hit');
            }
            if (!Schema::hasColumn('promocodes', 'repeat_order')) {
                $table->boolean('repeat_order')->default(false)->after('is_universal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('promocodes', function (Blueprint $table) {
            $table->dropColumn([
                'perfluence_promocode_id',
                'perfluence_landing_id',
                'promo_terms',
                'region_promo',
                'is_hit',
                'is_universal',
                'repeat_order',
            ]);
        });

        Schema::table('cards', function (Blueprint $table) {
            $table->dropColumn(['perfluence_project_id', 'perfluence_site']);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('perfluence_category_id');
        });
    }
};
