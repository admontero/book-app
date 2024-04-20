<?php

namespace Database\Factories;

use App\Enums\FineStatusEnum;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fine>
 */
class FineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'loan_id' => Loan::factory(),
            'user_id' => User::factory(),
            'days' => $this->faker->numberBetween(1, 30),
            'total' => $this->faker->numberBetween(5000, 20000),
            'status' => FineStatusEnum::cases()[rand(0, count(FineStatusEnum::cases()) - 1)]->value
        ];
    }
}
