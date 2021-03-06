<?php

namespace Database\Factories;

use App\Models\History;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class HistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = History::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween(5,11),
            'book_id' => $this->faker->numberBetween(5,11),
            'status' => $this->faker->randomElement(["APPROVED", "FINISHED"]),
        ];
    }
}
