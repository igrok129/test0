<?php

namespace App\Pipelines;

use App\Services\CountryValidationService;
use Closure;

class ExternalCountryValidationData
{
    public function __construct(private CountryValidationService $countryService)
    {
    }

    /**
     * Getting validation data from external resources.
     *
     * @param null    $passable
     * @param Closure $next
     *
     * @return array|null
     */
    public function handle(mixed $passable, Closure $next): ?array
    {
        $countryCodes = $this->countryService->getCountriesList();
        $timeZones    = $this->countryService->getTimeZonesList();

        if ($countryCodes && $timeZones) {
            return ['country_codes' => $countryCodes, 'time_zones' => $timeZones];
        }

        return $next($passable);
    }
}
