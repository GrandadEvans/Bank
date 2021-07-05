<?php

namespace Database\Factories;

use Bank\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * @var int
     */
    private int $defaultUserId = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->defaultUserId,
            'provider_id' => $this->faker->numberBetween(1, 10),
            'payment_method_id' => $this->faker->numberBetween(1, 15),
            'date' => $this->faker->dateTimeBetween('-1 year'),
            'amount' => $this->faker->randomFloat(2, -2000, 2000),
            'balance' => $this->faker->randomFloat(2, -100, 3000),
            'remarks' => $this->faker->sentence(),
            'entry' => $this->faker->randomElement([
                'Aldi',
                'Halifax Mortgage',
                'Halifax TMPP',
                'PetPlan 1',
                'Petplan 2',
                'Petplan',
                'Denplan',
                'Aldi',
                'ALDI',
                'LIDL',
                'Asda',
                'Tesco'
            ]),
        ];
    }
}
