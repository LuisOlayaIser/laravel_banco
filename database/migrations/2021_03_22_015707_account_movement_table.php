<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccountMovementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_movement', function (Blueprint $table) {
            $table->string('type');
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('movement_id');

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('movement_id')->references('id')->on('movements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_movement');
    }
}
