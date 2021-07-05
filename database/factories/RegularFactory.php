<?php

namespace Database\Factories;

use Bank\Models\Provider;
use Bank\Models\Regular;
use Bank\Models\User;
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
        return [
            'user_id' => $this->for(User::class),
            'provider_id' => $this->faker->numberBetween(1, Provider::all()->count()),
            'payment_method_id' => $this->faker->numberBetween(1, 16),
            'nextDue' => $this->faker->date(),
            'description' => $this->faker->sentence(3),
            'amount' => $this->faker->randomFloat(2, -2000, 2000),
            'estimated' => $this->faker->boolean(25),
            'days' => $this->faker->numberBetween(1, 9) . $this->faker->randomElement(['d', 'w', 'm', 'q', 'y']),
            'remarks' => $this->faker->sentence(),
        ];
    }
}
