<?php

namespace Tests\Unit\Services;

use App\Services\CountryValidationService;
use Faker\Factory;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Traits\ValidationCountryData;

class CountryValidationServiceTest extends TestCase
{
    use ValidationCountryData;

    private MockInterface $httpMock;
    private MockInterface $responseMock;
    private MockInterface $requestMock;
    private array         $countriesApiConf;
    private array         $timeZonesApiConf;

    public function setUp(): void
    {
        parent::setUp();
        Mockery::close();
        $faker                  = Factory::create();
        $this->httpMock         = Mockery::mock(sprintf('alias:%s', Http::class));
        $this->responseMock     = Mockery::mock(Response::class);
        $this->requestMock      = Mockery::mock(PendingRequest::class);
        $this->countriesApiConf = ['base_uri' => $faker->domainName, 'version' => 'v6.66', 'methods' => ['list' => 'all']];
        $this->timeZonesApiConf = ['base_uri' => $faker->domainName, 'methods' => ['list' => 'api/timezone']];
    }

    /**
     * Test successfully getting country list.
     *
     * @return void
     */
    public function test_successful_getting_country_list(): void
    {
        $countries = $this->getCountriesExternal();

        $this->responseMock->shouldReceive('failed')->once()->andReturn(false);
        $this->responseMock->shouldReceive('json')->once()->andReturn($countries);

        $this->requestMock->shouldReceive('get')->once()
            ->with(implode('/', [$this->countriesApiConf['version'], $this->countriesApiConf['methods']['list']]))
            ->andReturn($this->responseMock);

        $this->httpMock->shouldReceive('withOptions')->once()->with(['base_uri' => $this->countriesApiConf['base_uri']])
            ->andReturn($this->requestMock);

        $countryValidationService = new CountryValidationService($this->countriesApiConf, []);
        $this->assertSame(
            array_map(fn ($country) => ['cca2' => $country['cca2'] ?? '', 'country_name' => $country['name']['official'] ?? ''], $countries),
            $countryValidationService->getCountriesList()
        );
    }

    /**
     * Test unsuccessfully getting country list, because of failed response.
     *
     * @return void
     */
    public function test_fail_response_getting_country_list(): void
    {
        $this->responseMock->shouldReceive('failed')->once()->andReturn(true);
        $this->httpMock->shouldReceive('withOptions->get')->once()->andReturn($this->responseMock);

        $countryValidationService = new CountryValidationService($this->countriesApiConf, []);
        $this->assertSame([], $countryValidationService->getCountriesList());
    }

    /**
     * Test unsuccessfully getting country list, because of empty body.
     *
     * @return void
     */
    public function test_fail_empty_body_getting_country_list(): void
    {
        $this->responseMock->shouldReceive('failed')->once()->andReturn(false);
        $this->responseMock->shouldReceive('json')->once();

        $this->httpMock->shouldReceive('withOptions->get')->once()->andReturn($this->responseMock);

        $countryValidationService = new CountryValidationService($this->countriesApiConf, []);
        $this->assertSame([], $countryValidationService->getCountriesList());
    }

    /**
     * Test successfully getting time zones.
     *
     * @return void
     */
    public function test_successful_getting_time_zones(): void
    {
        $timeZones = $this->getTimeZonesExternal();

        $this->responseMock->shouldReceive('failed')->once()->andReturn(false);
        $this->responseMock->shouldReceive('json')->once()->andReturn($timeZones);

        $this->requestMock->shouldReceive('get')->once()->with($this->timeZonesApiConf['methods']['list'])
            ->andReturn($this->responseMock);

        $this->httpMock->shouldReceive('withOptions')->once()->with(['base_uri' => $this->timeZonesApiConf['base_uri']])
            ->andReturn($this->requestMock);

        $countryValidationService = new CountryValidationService([], $this->timeZonesApiConf);
        $this->assertSame(array_map(fn ($timeZone) => ['name' => $timeZone], $timeZones), $countryValidationService->getTimeZonesList());
    }

    /**
     * Test unsuccessfully getting time zones, because of failed response.
     *
     * @return void
     */
    public function test_fail_response_getting_time_zones(): void
    {
        $this->responseMock->shouldReceive('failed')->once()->andReturn(true);

        $this->httpMock->shouldReceive('withOptions->get')->once()->andReturn($this->responseMock);

        $countryValidationService = new CountryValidationService([], $this->timeZonesApiConf);
        $this->assertSame([], $countryValidationService->getTimeZonesList());
    }

    /**
     * Test unsuccessfully getting time zones, because of empty body.
     *
     * @return void
     */
    public function test_fail_empty_body_getting_time_zone(): void
    {
        $this->responseMock->shouldReceive('failed')->once()->andReturn(false);
        $this->responseMock->shouldReceive('json')->once();

        $this->httpMock->shouldReceive('withOptions->get')->once()->andReturn($this->responseMock);

        $countryValidationService = new CountryValidationService([], $this->timeZonesApiConf);
        $this->assertSame([], $countryValidationService->getTimeZonesList());
    }
}
