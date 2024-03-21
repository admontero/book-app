<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Editorial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Edition>
 */
class EditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'isbn13' => $this->faker->unique()->numerify('#############'),
            'pages' => $this->faker->numberBetween(50, 1000),
            'year' => $this->faker->year(),
            'editorial_id' => Editorial::factory(),
            'book_id' => Book::factory(),
        ];
    }

    public function existing(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'editorial_id' => rand(1, 50),
                'book_id' => rand(1, 100),
            ];
        });
    }
}
