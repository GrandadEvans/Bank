<?php

namespace Database\Factories;

use Bank\Models\Tag;
use Bank\UtilityClasses\ColorUtilities;
use Bank\UtilityClasses\Icons;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $default_color = $this->faker->hexColor();

        return [
            'created_by_user_id' => 1,
            'tag' => $this->faker->word(),
            'default_color' => $default_color,
            'contrasted_color' => ColorUtilities::blackWhiteContrast($default_color),
            'icon' => $this->faker->randomElement(Icons::randomIcon())
        ];
    }

}

