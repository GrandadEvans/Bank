<?php

namespace Database\Factories;

use Bank\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'remarks' => $this->faker->sentence(4),
            'logo' => $this->faker->imageUrl(),
            'regular_expressions' => "/" . $this->faker->sentence(3) . "/i",
            'payment_method_id' => $this->faker->numberBetween(1, 16)
        ];
    }
}
