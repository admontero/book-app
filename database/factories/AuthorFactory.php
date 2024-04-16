<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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

        $firstname = $this->faker->firstName;

        $lastname = $this->faker->lastName;

        $pseudonym = $firstname  . ' ' . $lastname;

        $biography = '';

        $paragraphs = $this->faker->paragraphs(rand(4, 8));

        foreach ($paragraphs as $paragraph) {
            $biography .= "<p>{$paragraph}</p>";
        }

        return [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'pseudonym' => $pseudonym,
            'date_of_birth' => $this->faker->dateTimeThisCentury('-18 years'),
            'country_birth_id' => $country_birth_id,
            'state_birth_id' => $state_birth_id,
            'city_birth_id' => $city_birth_id,
            'biography' => $biography,
        ];
    }
}
