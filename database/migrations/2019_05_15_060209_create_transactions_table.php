<?php

use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\User;
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
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Provider::class)->default(1);
            $table->foreignIdFor(PaymentMethod::class);
            $table->boolean('isPartOfRegular')->default(false);
            $table->date('date')->index('transaction_date');
            $table->string('entry', 255)->index('transaction_entry');
            $table->decimal('amount')->nullable();
            $table->decimal('balance')->nullable();
            $table->text('remarks', 255)->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
