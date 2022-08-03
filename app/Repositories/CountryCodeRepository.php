<?php

namespace App\Repositories;

use App\Models\CountryCode;
use Czim\Repository\BaseRepository;
use Czim\Repository\Exceptions\RepositoryException;

/**
 * @method static CountryCode makeModel()
 */
class CountryCodeRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return CountryCode::class;
    }

    /**
     * Check whether $countryCode is valid or not, it can be both: country_name or cca2.
     *
     * @param string $countryCode
     *
     * @return bool
     *
     * @throws RepositoryException
     */
    public function isCountryCodeValid(string $countryCode): bool
    {
        return $this->makeModel()->newQuery()->where('country_name', $countryCode)
            ->orWhere('cca2', $countryCode)->exists();
    }

    /**
     * Transform $country to cca2 code, if it was country_name.
     *
     * @param string|null $country
     *
     * @return string|null
     *
     * @throws RepositoryException
     */
    public function transformCountryName(?string $country): ?string
    {
        /** @var CountryCode $countryCode */
        $countryCode = $this->makeModel()->newQuery()->whereCountryName($country)->first();

        return $countryCode->cca2 ?? $country;
    }
}
