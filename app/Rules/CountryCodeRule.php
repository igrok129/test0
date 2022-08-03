<?php

namespace App\Rules;

use App\Repositories\CountryCodeRepository;
use Illuminate\Contracts\Validation\Rule;
use Czim\Repository\Exceptions\RepositoryException;

class CountryCodeRule implements Rule
{
    private CountryCodeRepository $countryRepository;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(CountryCodeRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     *
     * @throws RepositoryException
     */
    public function passes($attribute, $value): bool
    {
        return $this->countryRepository->isCountryCodeValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return trans('validation.custom.country_code');
    }
}
