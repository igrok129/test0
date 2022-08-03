<?php

namespace App\Http\Requests\PhoneBook;

use App\Models\TimeZone;
use App\Rules\CountryCodeRule;
use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['name' => 'string', 'second_name' => 'string', 'phone_number' => 'array', 'country_code' => 'array', 'timezone' => 'string'])]
    public function rules(): array
    {
        return [
            'name'         => 'required|string',
            'second_name'  => 'string|filled',
            'phone_number' => ['required', new PhoneRule()],
            'country_code' => ['string', 'filled', resolve(CountryCodeRule::class)],
            'timezone'     => sprintf('string|filled|exists:%s,name', TimeZone::class),
        ];
    }
}
