<?php

namespace Database\Factories;

use App\Models\PhoneBook;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory<PhoneBook>
 */
class PhoneBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => 'string', 'second_name' => 'string', 'phone_number' => 'string', 'country_code' => 'string', 'timezone' => 'string'])]
    public function definition(): array
    {
        return [
            'name'         => $this->faker->name,
            'second_name'  => $this->faker->lastName,
            'phone_number' => $this->faker->e164PhoneNumber,
            'country_code' => $this->faker->countryCode,
            'timezone'     => $this->faker->timezone,
        ];
    }
}
