<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'telegram_id')) {
                $table->bigInteger('telegram_id')->nullable(); // Добавление колонки telegram_id
            }
            if (!Schema::hasColumn('users', 'first_name')) {
                $table->string('first_name')->nullable(); // Добавление колонки first_name
            }
            if (!Schema::hasColumn('users', 'last_name')) {
                $table->string('last_name')->nullable(); // Добавление колонки last_name
            }
            if (!Schema::hasColumn('users', 'telegram_username')) {
                $table->string('telegram_username')->nullable(); // Добавление колонки telegram_username
            }
            if (!Schema::hasColumn('users', 'image')) {
                $table->string('image')->nullable(); // Добавление колонки image
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('telegram_id');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('telegram_username');
            $table->dropColumn('image');
        });
    }
};
