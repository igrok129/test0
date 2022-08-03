<?php

namespace Tests\Stubs\Traits;

use Faker\Factory;

trait ValidationCountryData
{
    /**
     * Get fake body of countries validation api response.
     *
     * @return array
     */
    private function getCountriesExternal(): array
    {
        $faker = $this->faker ?? Factory::create();
        $body  = [];

        for ($i = 0; $i < 8; $i++) {
            $body[] = ['cca2' => $faker->countryCode, 'name' => ['official' => $faker->country]];
        }
        array_push($body, ['name' => ['official' => $faker->country]], ['cca2' => $faker->countryCode]);

        return $body;
    }

    /**
     * Get fake body of time zones validation api response.
     *
     * @return array
     */
    private function getTimeZonesExternal(): array
    {
        $faker = $this->faker ?? Factory::create();
        $body  = [];

        for ($i = 0; $i < 10; $i++) {
            $body[] = $faker->timezone;
        }

        return $body;
    }

    /**
     * Get countries local data.
     *
     * @return array
     */
    private function getCountriesLocalData(): array
    {
        $faker = $this->faker ?? Factory::create();
        $data  = [];

        for ($i = 0; $i < 10; $i++) {
            $data[$faker->countryCode] = $faker->country;
        }

        return $data;
    }

    /**
     * Get timezones local data.
     *
     * @return array
     */
    private function getTimeZonesLocalData(): array
    {
        $faker = $this->faker ?? Factory::create();
        $data  = [];

        for ($i = 0; $i < 10; $i++) {
            $data[$faker->timezone] = ['value' => 'value', 'offset' => 'offset'];
        }

        return $data;
    }
}
