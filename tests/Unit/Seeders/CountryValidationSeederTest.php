<?php

namespace Tests\Unit\Seeders;

use App\Exceptions\DatabaseSeedException;
use Database\Seeders\CountryValidationSeeder;
use Illuminate\Database\Query\Builder;
use Illuminate\Pipeline\Hub;
use Illuminate\Support\Facades\DB;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

class CountryValidationSeederTest extends TestCase
{
    private CountryValidationSeeder $seeder;
    private MockInterface           $hubMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seeder  = new CountryValidationSeeder();
        $this->hubMock = Mockery::mock(Hub::class);
    }

    /**
     * Testing bad case of CountryValidationSeeder.
     *
     * @return void
     *
     * @throws DatabaseSeedException
     */
    public function test_unable_to_seed(): void
    {
        $this->hubMock->shouldReceive('pipe')->once()->with(null, 'get-country-validation-data');

        $this->expectException(DatabaseSeedException::class);
        $this->expectExceptionMessage('Unable to fetch data for country validation from any sources.');

        $this->seeder->run($this->hubMock);
    }

    /**
     * Testing good case of CountryValidationSeeder.
     *
     * @return void
     *
     * @throws DatabaseSeedException
     */
    public function test_successful_seeding(): void
    {
        $mockBuilder = Mockery::mock(Builder::class);
        $this->hubMock->shouldReceive('pipe')->once()->andReturn(['country_codes' => ['foo'], 'time_zones' => ['bar']]);

        $mockBuilder->shouldReceive('insert')->once()->with(['foo']);
        $mockBuilder->shouldReceive('insert')->once()->with(['bar']);

        DB::shouldReceive('table')->with('country_codes')->once()->andReturn($mockBuilder);
        DB::shouldReceive('table')->with('time_zones')->once()->andReturn($mockBuilder);

        $this->seeder->run($this->hubMock);
        $this->expectNotToPerformAssertions();
    }
}
