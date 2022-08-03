<?php

namespace App\Pipelines;

use Closure;
use Illuminate\Support\Facades\Storage;

class InternalCountryValidationData
{
    /**
     * Getting validation data from local files.
     *
     * @param null    $passable
     * @param Closure $next
     *
     * @return array|null
     */
    public function handle($passable, Closure $next): ?array
    {
        $countryCodes = json_decode((string) Storage::get('countries_validation_info/country_codes.txt'), true);
        $timeZones    = json_decode((string) Storage::get('countries_validation_info/timezones.txt'), true);

        if ($countryCodes && $timeZones) {
            $countryCodesForInsert = array_map(function (string $k, string $v): array {
                return ['cca2' => $k, 'country_name' => $v];
            }, array_keys($countryCodes), $countryCodes);

            $timeZonesForInsert = array_map(fn (string $k): array => ['name' => $k], array_keys($timeZones));

            return ['country_codes' => $countryCodesForInsert, 'time_zones' => $timeZonesForInsert];
        }

        return $next($passable);
    }
}
