<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pseudonym>
 */
class PseudonymFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $description = '';

        $paragraphs = $this->faker->paragraphs(rand(4, 8));

        foreach ($paragraphs as $paragraph) {
            $description .= "<p>{$paragraph}</p>";
        }

        return [
            'author_id' => Author::factory(),
            'name' => $this->faker->name,
            'description' => $description,
        ];
    }

    public function existing(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'author_id' => rand(1, 50),
            ];
        });
    }
}
