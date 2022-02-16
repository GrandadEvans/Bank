<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePossibleRegularsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('possible_regulars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('entry')->comment('The text value of the entry searched for');
            $table->string('period_name', 100)->comment('The period the entry was declined for');
            $table->integer('period_multiplier')->default(1);
            $table
                ->enum('last_action', [
                    'accepted',
                    'declined',
                    'postponed',
                    'created'
                ])
                ->default('created')
                ->comment('What did the user choose to do with this suggestion?');
            $table->dateTime('last_action_happened')->default(now());
            $table->timestamps();
            // I'm not creating an index as it would have to be ['user_id', 'entry', 'period']
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('possible_regulars');
    }
}
