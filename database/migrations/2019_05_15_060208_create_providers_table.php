<?php

use Bank\Models\PaymentMethod;
use Bank\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->comment('The user who created the provider');
            $table->foreignIdFor(PaymentMethod::class);
            $table->string('name', 100)->index('provider_name')->unique();
            $table->text('regular_expressions')->nullable();
            $table->string('logo', 255)->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('providers');
    }
}
