<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->decimal('value', $scale = 2);
            $table->unsignedBigInteger('payer_id');
            $table->integer('payee_id');
            $table->enum('status', ['pending', 'completed', 'canceled']);
            $table->timestamps();

            //foreign key (constraints)
            $table->foreign('payer_id')->references('id')->on('users');
            $table->unique('payer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
