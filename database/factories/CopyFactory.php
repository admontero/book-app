<?php

namespace Database\Factories;

use App\Enums\CopyStatusEnum;
use App\Models\Edition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Copy>
 */
class CopyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identifier' => strtoupper($this->faker->unique()->bothify('????-####')),
            'edition_id' => Edition::factory(),
            'is_loanable' => rand(0, 1),
            'status' => Arr::random(CopyStatusEnum::cases()),
        ];
    }

    public function existing(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'edition_id' => rand(1, 200),
            ];
        });
    }
}
