<?php

namespace Tests\Unit\Repositories;

use App\Models\CountryCode;
use App\Repositories\CountryCodeRepository;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Builder;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Czim\Repository\Exceptions\RepositoryException;

class CountryCodeRepositoryTest extends TestCase
{
    private Generator $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
    }

    /**
     * Testing transformCountryName method with country_name.
     *
     * @return void
     *
     * @throws RepositoryException
     */
    public function test_transform_country_name(): void
    {
        $countryCode = new CountryCode(['cca2' => $this->faker->countryCode, 'country_name' => $this->faker->country]);

        $builderMock = Mockery::mock(Builder::class);
        $builderMock->shouldReceive('whereCountryName')->once()->with($countryCode->country_name)->andReturn($builderMock);
        $builderMock->shouldReceive('first')->once()->andReturn($countryCode);

        $countryCodeMock = Mockery::mock(CountryCode::class)->makePartial();
        $countryCodeMock->shouldReceive('newQuery')->once()->andReturn($builderMock);

        /** @var MockInterface|CountryCodeRepository $countryCodeRepositoryMock */
        $countryCodeRepositoryMock = Mockery::mock(CountryCodeRepository::class)->makePartial();
        $countryCodeRepositoryMock->shouldReceive('makeModel')->once()->andReturn($countryCodeMock);

        $this->assertSame($countryCode->cca2, $countryCodeRepositoryMock->transformCountryName($countryCode->country_name));
    }

    /**
     * Testing transformCountryName method with cca2.
     *
     * @return void
     *
     * @throws RepositoryException
     */
    public function test_transform_country_name_cca2_code(): void
    {
        $countryCode = new CountryCode(['cca2' => $this->faker->countryCode, 'country_name' => $this->faker->country]);

        /** @var MockInterface|CountryCodeRepository $countryCodeRepositoryMock */
        $countryCodeRepositoryMock = Mockery::mock(CountryCodeRepository::class)->makePartial();
        $countryCodeRepositoryMock->shouldReceive('makeModel->newQuery->whereCountryName->first')->once();

        $this->assertSame($countryCode->cca2, $countryCodeRepositoryMock->transformCountryName($countryCode->cca2));
    }
}
