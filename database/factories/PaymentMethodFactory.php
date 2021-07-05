<?php

namespace Database\Factories;

use Bank\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PaymentMethod::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'abbreviation' => str_repeat($this->faker->randomLetter(), $this->faker->numberBetween(2, 4)),
            'method' => $this->faker->sentence(2),
            'logo' => $this->faker->imageUrl(),
        ];
    }
}
