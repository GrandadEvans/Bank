<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('provider_id')->default(1);
            $table->unsignedBigInteger('payment_method_id');
            $table->date('date')->index('transaction_date');
            $table->string('entry', 255)->index('transaction_entry');
            $table->decimal('amount')->nullable();
            $table->decimal('balance')->nullable();
            $table->string('remarks', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_id'          )->references('id')->on('users');
            $table->foreign('provider_id'      )->references('id')->on('providers');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
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
