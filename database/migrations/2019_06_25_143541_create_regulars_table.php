<?php

use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\User;
use Bank\UtilityClasses\TimePeriods;
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
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Provider::class)->default(1);
            $table->foreignIdFor(PaymentMethod::class);

            //$table->string('alias')->fulltext();
            //$table->string('entry_text')->fulltext();
            $table->string('alias');
            $table->string('entry_text');
            $table->decimal('amount', 6, 2)->nullable();
            $table->boolean('amount_varies')->default(false);
            $table->enum('period_name', TimePeriods::$availablePeriods);
            $table->string('period_multiplier');
            //$table->text('remarks')->nullable()->fulltext();
            $table->text('remarks')->nullable();

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
