<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CountryCode;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory<CountryCode>
 */
class CountryCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['country_name' => 'string', 'cca2' => 'string'])]
    public function definition(): array
    {
        return ['country_name' => $this->faker->country, 'cca2' => $this->faker->countryCode];
    }
}
