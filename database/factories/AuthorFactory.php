<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $country_birth_id = Country::inRandomOrder()->first()?->id;

        $state_birth_id = $country_birth_id
            ? State::where('country_id', $country_birth_id)->inRandomOrder()->first()?->id
            : null;

        $city_birth_id = $state_birth_id
            ? City::where('state_id', $state_birth_id)->inRandomOrder()->first()?->id
            : null;

        $first_name = $this->faker->firstName;

        $middle_name = Arr::random([$this->faker->firstName, null]);

        $first_surname = $this->faker->lastName;

        $second_surname = Arr::random([$this->faker->lastName, null]);

        return [
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'first_surname' => $first_surname,
            'second_surname' => $second_surname,
            'date_of_birth' => $this->faker->dateTimeThisCentury('-18 years'),
            'country_birth_id' => $country_birth_id,
            'state_birth_id' => $state_birth_id,
            'city_birth_id' => $city_birth_id,
        ];
    }
}
