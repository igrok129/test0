<?php

namespace App\Observers;

use App\Models\PhoneBook;
use App\Repositories\CountryCodeRepository;
use Czim\Repository\Exceptions\RepositoryException;

class PhoneBookObserver
{
    public function __construct(private CountryCodeRepository $countryCodeRepo)
    {
    }

    /**
     * Changing country_code raw to cca2, if it was country_name, before creating.
     *
     * @param PhoneBook $phoneBook
     *
     * @return void
     *
     * @throws RepositoryException
     */
    public function creating(PhoneBook $phoneBook): void
    {
        $phoneBook->country_code = $this->countryCodeRepo->transformCountryName($phoneBook->country_code);
    }

    /**
     * Changing country_code raw to cca2, if it was country_name, before updating.
     *
     * @param PhoneBook $phoneBook
     *
     * @return void
     *
     * @throws RepositoryException
     */
    public function updating(PhoneBook $phoneBook): void
    {
        $phoneBook->country_code = $this->countryCodeRepo->transformCountryName($phoneBook->country_code);
    }
}
