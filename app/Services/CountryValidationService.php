<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CountryValidationService
{
    public function __construct(private array $countriesApiConf, private array $timeZonesApiConf)
    {
    }

    /**
     * Getting country list from external api.
     *
     * @return array
     */
    public function getCountriesList(): array
    {
        $response = Http::withOptions(['base_uri' => $this->countriesApiConf['base_uri']])
            ->get(implode('/', [$this->countriesApiConf['version'], $this->countriesApiConf['methods']['list']]));

        if ($response->failed()) {
            return [];
        }

        return array_map(fn ($country) => ['cca2' => $country['cca2'] ?? '', 'country_name' => $country['name']['official'] ?? ''], $response->json() ?? []);
    }

    /**
     * Getting time zone list from external api.
     *
     * @return array
     */
    public function getTimeZonesList(): array
    {
        $response = Http::withOptions(['base_uri' => $this->timeZonesApiConf['base_uri']])
            ->get($this->timeZonesApiConf['methods']['list']);

        if ($response->failed()) {
            return [];
        }

        return array_map(fn ($timeZone) => ['name' => $timeZone], $response->json() ?? []);
    }
}
