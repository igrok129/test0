<?php

namespace Tests\Feature\Seeders;

use App\Exceptions\DatabaseSeedException;
use Database\Seeders\CountryValidationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Tests\Stubs\Traits\ValidationCountryData;
use Tests\TestCase;

class CountryValidationSeederTest extends TestCase
{
    use RefreshDatabase;
    use ValidationCountryData;

    /**
     * Testing bad case of CountryValidationSeeder.
     *
     * @return void
     */
    public function test_unable_to_seed_from_sources(): void
    {
        Http::fake();
        Storage::fake();

        $this->expectException(DatabaseSeedException::class);
        $this->expectExceptionMessage('Unable to fetch data for country validation from any sources.');

        $this->artisan('db:seed', ['--class' => CountryValidationSeeder::class]);
    }

    /**
     * Testing good case of CountryValidationSeeder from external sources.
     *
     * @return void
     */
    public function test_successful_seeding_external(): void
    {
        $countries = $this->getCountriesExternal();
        $timeZones = $this->getTimeZonesExternal();

        Http::fake([
            sprintf('%s/*', config('external.countries.base_uri')) => Http::response($countries),
            sprintf('%s/*', config('external.timezones.base_uri')) => Http::response($timeZones),
        ]);

        $this->artisan('db:seed', ['--class' => CountryValidationSeeder::class]);

        for ($i = 0; $i < 10; $i++) {
            $this->assertDatabaseHas('country_codes', [
                'cca2'         => $countries[$i]['cca2']             ?? '',
                'country_name' => $countries[$i]['name']['official'] ?? '',
            ]);
            $this->assertDatabaseHas('time_zones', ['name' => $timeZones[$i]]);
        }
    }

    /**
     * Testing good case of CountryValidationSeeder from local source.
     *
     * @return void
     */
    public function test_successful_seeding_local(): void
    {
        Storage::fake();
        Http::fake([
            sprintf('%s/*', config('external.countries.base_uri')) => Http::response([], Response::HTTP_BAD_REQUEST),
            sprintf('%s/*', config('external.timezones.base_uri')) => Http::response([], Response::HTTP_BAD_REQUEST),
        ]);

        $countries = $this->getCountriesLocalData();
        $timeZones = $this->getTimeZonesLocalData();

        Storage::putFileAs('countries_validation_info', UploadedFile::fake()
            ->createWithContent('country_codes.txt', json_encode($countries)), 'country_codes.txt');
        Storage::putFileAs('countries_validation_info', UploadedFile::fake()
            ->createWithContent('timezones.txt', json_encode($timeZones)), 'timezones.txt');

        $this->artisan('db:seed', ['--class' => CountryValidationSeeder::class]);

        foreach ($countries as $code => $country) {
            $this->assertDatabaseHas('country_codes', ['cca2' => $code, 'country_name' => $country]);
        }
        foreach (array_keys($timeZones) as $timeZone) {
            $this->assertDatabaseHas('time_zones', ['name' => $timeZone]);
        }
    }
}
