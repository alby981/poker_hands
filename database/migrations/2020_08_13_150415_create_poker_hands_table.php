<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePokerHandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poker_hands', function (Blueprint $table) {
            $table->id();
            $table->string('handPlayer1');
            $table->string('handPlayer2');
            $table->string('winner');
            $table->string('with');
            $table->string('vs');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poker_hands');
    }
}
