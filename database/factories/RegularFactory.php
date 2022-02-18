<?php

namespace Database\Factories;

use Bank\Models\Provider;
use Bank\Models\Regular;
use Bank\Models\User;
use Bank\UtilityClasses\TimePeriods;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegularFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Regular::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $periods = TimePeriods::$availablePeriods;

        return [
            'user_id' => $this->for(User::class),
            'provider_id' => $this->faker->numberBetween(1, Provider::all()->count()),
            'payment_method_id' => $this->faker->numberBetween(1, 16),
            'amount' => $this->faker->randomFloat(2, -2000, 2000),
            'amount_varies' => $this->faker->boolean(25),
            'period_name' => $this->faker->randomElement($periods),
            'period_multiplier' => $this->faker->numberBetween(1, 4),
            'remarks' => $this->faker->sentence(),
            'next_due' => $this->faker->date(),
        ];
    }
}
