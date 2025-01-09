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
        Schema::create('promocodes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('reward')->nullable();
            $table->string('link')->nullable();
            $table->unsignedBigInteger('card_id')->nullable();
            $table->timestamps();

            $table->index('card_id', 'promocode_card_idx');
            $table->foreign('card_id', 'promocode_card_fk')->references('id')->on('cards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocodes');
    }
};
