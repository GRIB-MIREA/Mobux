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
        Schema::create('card_stamps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('card_id');
            $table->unsignedBigInteger('stamp_id');
            $table->timestamps();

            $table->index('card_id', 'card_stamp_card_idx');
            $table->index('stamp_id', 'card_stamp_stamp_idx');
            $table->foreign('card_id', 'card_stamp_card_fk')->references('id')->on('cards');
            $table->foreign('stamp_id', 'card_stamp_stamp_fk')->references('id')->on('stamps');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('card_stamps');
    }
};
