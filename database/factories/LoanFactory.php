<?php

namespace Database\Factories;

use App\Enums\LoanStatusEnum;
use App\Models\Copy;
use App\Models\Fine;
use App\Models\Loan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Loan $loan) {
            if (
                $loan->status = LoanStatusEnum::COMPLETADO->value &&
                $loan->is_fineable &&
                $loan->devolution_date &&
                $loan->devolution_date->isAfter($loan->limit_date)
            ) {
                $days = $loan->devolution_date->diffInDays($loan->limit_date);

                Fine::factory()->create([
                    'loan_id' => $loan->id,
                    'user_id' => $loan->user_id,
                    'days' => $days,
                    'total' => $loan->fine_amount * $days,
                ]);
            }
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = $this->faker->dateTimeThisMonth()->format('Y-m-d');

        $limit_date = Carbon::parse($start_date)->addDays(rand(3, 6));

        $is_fineable = rand(0, 1);

        $fine_amount = $is_fineable ? rand(1000, 10000) : null;

        $status = LoanStatusEnum::cases()[rand(0, count(LoanStatusEnum::cases()) - 1)]->value;

        $devolution_date = $status == LoanStatusEnum::COMPLETADO->value ?  Carbon::parse($limit_date)->addDays(rand(-2, 2)) : null;

        return [
            'copy_id' => Copy::factory(),
            'user_id' => User::factory(),
            'start_date' => $start_date,
            'limit_date' => $limit_date,
            'devolution_date' => $devolution_date,
            'is_fineable' => $is_fineable,
            'fine_amount' => $fine_amount,
            'status' => $status,
        ];
    }

    public function existing(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'copy_id' => Copy::inRandomOrder()->first(),
                'user_id' => User::whereHas('roles', fn ($query) => $query->whereIn('name', ['lector']))->inRandomOrder()->first(),
            ];
        });
    }
}
