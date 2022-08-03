<?php

namespace App\Http\Requests\PhoneBook;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['id' => 'string', 'name' => 'string', 'second_name' => 'string'])]
    public function rules(): array
    {
        return ['id' => 'int|nullable', 'name' => 'string|nullable', 'second_name' => 'string|nullable'];
    }
}
