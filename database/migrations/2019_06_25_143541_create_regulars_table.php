<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->foreignIdFor(\Bank\Models\User::class);
            $table->foreignIdFor(\Bank\Models\Provider::class)->default(1);
            $table->foreignIdFor(\Bank\Models\PaymentMethod::class);

            $table->decimal('amount', 6, 2)->nullable();
            $table->boolean('amount_varies')->default(false);
            $table->string('period_name');
            $table->string('period_multiplier');
            $table->string('remarks', 255)->nullable();

            $table->date('next_due')->index('regulars_date');
            $table->date('last_rotated')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('regulars');
    }
}
