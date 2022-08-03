<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TimeZone;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends Factory<TimeZone>
 */
class TimeZoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => 'string'])]
    public function definition(): array
    {
        return ['name' => $this->faker->timezone];
    }
}
