<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->string('alias');
            $table->double('balance')->default(1000000);
            $table->unsignedBigInteger('bank_id');
            $table->unsignedBigInteger('account_type_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('account_type_id')->references('id')->on('account_types');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
