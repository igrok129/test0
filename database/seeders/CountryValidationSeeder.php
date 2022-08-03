<?php

namespace Database\Seeders;

use App\Exceptions\DatabaseSeedException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Pipeline\Hub;
use Illuminate\Support\Facades\DB;

class CountryValidationSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the validation country tables.
     *
     * @param Hub $hub
     *
     * @return void
     *
     * @throws DatabaseSeedException
     */
    public function run(Hub $hub): void
    {
        $countryValidationData = $hub->pipe(null, 'get-country-validation-data');

        ! $countryValidationData && throw new DatabaseSeedException('Unable to fetch data for country validation from any sources.');

        DB::table('country_codes')->insert($countryValidationData['country_codes']);
        DB::table('time_zones')->insert($countryValidationData['time_zones']);
    }
}
