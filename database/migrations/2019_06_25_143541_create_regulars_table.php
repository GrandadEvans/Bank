<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regulars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('regulars_user_id');
            $table->unsignedBigInteger('provider_id')->index('regulars_provider_id')->default(1);
            $table->date('nextDue')->index('regulars_date');
            $table->date('lastRotated')->nullable();
            $table->string('description', 255);
            $table->unsignedBigInteger('payment_method_id');
            $table->decimal('amount', 6, 2)->nullable();
            $table->boolean('estimated')->default(false);
            $table->string('days')->index('regulars_days');
            $table->string('remarks', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('provider_id')->references('id')->on('providers');
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
        Schema::dropIfExists('regulars');
    }
}
