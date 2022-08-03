<?php

namespace App\Providers;

use App\Pipelines\ExternalCountryValidationData;
use App\Pipelines\InternalCountryValidationData;
use App\Services\CountryValidationService;
use Illuminate\Pipeline\Hub;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Sanctum::ignoreMigrations();

        $this->app->when(CountryValidationService::class)->needs('$countriesApiConf')
            ->give(config('external.countries'));
        $this->app->when(CountryValidationService::class)->needs('$timeZonesApiConf')
            ->give(config('external.timezones'));

        $this->app->extend(Hub::class, function (Hub $hub): Hub {
            $hub->pipeline('get-country-validation-data', function (Pipeline $pipeline): ?array {
                return $pipeline->through([ExternalCountryValidationData::class, InternalCountryValidationData::class])
                    ->thenReturn();
            });

            return $hub;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
