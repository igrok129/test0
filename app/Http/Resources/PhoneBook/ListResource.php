<?php

namespace App\Http\Resources\PhoneBook;

use App\Models\PhoneBook;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

/**
 * @mixin PhoneBook
 */
class ListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array|Arrayable|JsonSerializable
     */
    #[ArrayShape(['id' => 'int', 'name' => 'string', 'second_name' => 'null|string', 'phone_number' => 'string'])]
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'second_name'  => $this->second_name,
            'phone_number' => $this->phone_number,
        ];
    }
}
