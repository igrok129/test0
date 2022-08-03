<?php

namespace Tests\Unit\Pipelines;

use App\Pipelines\InternalCountryValidationData;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Tests\Stubs\Traits\ValidationCountryData;

class InternalCountryValidationDataTest extends TestCase
{
    use ValidationCountryData;

    private MockInterface $storageMock;

    protected function setUp(): void
    {
        parent::setUp();
        Mockery::close();
        $this->storageMock = Mockery::mock(sprintf('alias:%s', Storage::class));
    }

    /**
     * Test successful getting validation data through internal source.
     *
     * @return void
     */
    public function test_successful_getting(): void
    {
        $countryCodes = $this->getCountriesLocalData();
        $timeZones    = $this->getTimeZonesLocalData();

        $this->storageMock->shouldReceive('get')->once()->with('countries_validation_info/country_codes.txt')
            ->andReturn(json_encode($countryCodes));
        $this->storageMock->shouldReceive('get')->once()->with('countries_validation_info/timezones.txt')
            ->andReturn(json_encode($timeZones));

        $internalPipe = new InternalCountryValidationData();
        $this->assertSame([
            'country_codes' => array_map(fn (string $k, string $v): array => ['cca2' => $k, 'country_name' => $v], array_keys($countryCodes), $countryCodes),
            'time_zones'    => array_map(fn (string $k): array => ['name' => $k], array_keys($timeZones)),
        ], $internalPipe->handle(null, fn (mixed $passable) => $passable));
    }

    /**
     * Test unsuccessful getting validation data through internal source.
     *
     * @return void
     */
    public function test_unsuccessful_getting(): void
    {
        $this->storageMock->shouldReceive('get')->once()->with('countries_validation_info/country_codes.txt');
        $this->storageMock->shouldReceive('get')->once()->with('countries_validation_info/timezones.txt');

        $internalPipe = new InternalCountryValidationData();
        $this->assertNull($internalPipe->handle(null, fn (mixed $passable) => $passable));
    }
}
