<?php

namespace Tests\Unit\Pipelines;

use App\Pipelines\ExternalCountryValidationData;
use App\Services\CountryValidationService;
use Closure;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class ExternalCountryValidationDataTest extends TestCase
{
    private MockInterface $countryServiceMock;
    private Closure       $next;

    public function setUp(): void
    {
        $this->countryServiceMock = Mockery::mock(CountryValidationService::class);
        $this->next               = fn (mixed $passable) => $passable;
    }

    /**
     * Test successful getting validation data through external sources.
     *
     * @return void
     */
    public function test_successful_getting(): void
    {
        $this->countryServiceMock->shouldReceive('getCountriesList')->once()->andReturn(['foo']);
        $this->countryServiceMock->shouldReceive('getTimeZonesList')->once()->andReturn(['bar']);

        $externalPipe = new ExternalCountryValidationData($this->countryServiceMock);

        $this->assertSame(['country_codes' => ['foo'], 'time_zones' => ['bar']], $externalPipe->handle(null, $this->next));
    }

    /**
     * Test unsuccessful getting validation data through external sources.
     *
     * @return void
     */
    public function test_unsuccessful_getting()
    {
        $this->countryServiceMock->shouldReceive('getCountriesList')->once();
        $this->countryServiceMock->shouldReceive('getTimeZonesList')->once();

        $externalPipe = new ExternalCountryValidationData($this->countryServiceMock);

        $this->assertNull($externalPipe->handle(null, $this->next));
    }
}
