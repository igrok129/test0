<?php

namespace Tests\Feature\Controllers;

use App\Http\Resources\PhoneBook\ListResource;
use App\Models\CountryCode;
use App\Models\PhoneBook;
use App\Models\TimeZone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhoneBookControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Testing phone-book.index method without filters.
     *
     * @return void
     */
    public function test_index(): void
    {
        $rows = PhoneBook::factory(3)->create();

        $this->getJson(route('phone-book.index'))->assertOk()->assertExactJson(ListResource::collection($rows)->resolve());
    }

    /**
     * Testing phone-book.index method with filters.
     *
     * @return void
     */
    public function test_index_filtered(): void
    {
        PhoneBook::factory(3)->create();

        /** @var PhoneBook $filteredRow */
        $filteredRow = PhoneBook::factory()->create();

        $this->getJson(route('phone-book.index', [
            'id'          => $filteredRow->id,
            'name'        => $filteredRow->name,
            'second_name' => $filteredRow->second_name,
        ]))->assertOk()->assertExactJson([ListResource::make($filteredRow)->resolve()]);
    }

    /**
     * Testing phone-book.store method with country_name.
     *
     * @return void
     */
    public function test_store_with_country_name(): void
    {
        /** @var CountryCode $countryCode */
        $countryCode = CountryCode::factory()->create();
        /** @var TimeZone $timeZone */
        $timeZone    = TimeZone::factory()->create();

        $data = [
            'name'         => $this->faker->name,
            'second_name'  => $this->faker->lastName,
            'phone_number' => $this->faker->e164PhoneNumber,
            'country_code' => $countryCode->country_name,
            'timezone'     => $timeZone->name,
        ];

        $this->postJson(route('phone-book.store'), $data)->assertCreated()->assertExactJson(['status' => 'success']);
        $this->assertDatabaseHas('phone_book', array_merge($data, ['country_code' => $countryCode->cca2]));
    }

    /**
     * Testing phone-book.store method with cca2 code.
     *
     * @return void
     */
    public function test_store_with_cca2_code(): void
    {
        /** @var CountryCode $countryCode */
        $countryCode = CountryCode::factory()->create();

        $data = [
            'name'         => $this->faker->name,
            'phone_number' => $this->faker->e164PhoneNumber,
            'country_code' => $countryCode->cca2,
        ];

        $this->postJson(route('phone-book.store'), $data)->assertCreated()->assertExactJson(['status' => 'success']);
        $this->assertDatabaseHas('phone_book', $data);
    }

    /**
     * Testing phone-book.show method.
     *
     * @return void
     */
    public function test_show(): void
    {
        /** @var PhoneBook $phoneBook */
        $phoneBook = PhoneBook::factory()->create();

        $this->getJson(route('phone-book.show', ['phone_book' => $phoneBook->id]))->assertOk()
            ->assertExactJson($phoneBook->toArray());
    }

    /**
     * Testing phone-book.update method.
     *
     * @return void
     */
    public function test_update(): void
    {
        /** @var PhoneBook $phoneBook */
        $phoneBook   = PhoneBook::factory()->create();
        /** @var CountryCode $countryCode */
        $countryCode = CountryCode::factory()->create();
        /** @var TimeZone $timeZone */
        $timeZone    = TimeZone::factory()->create();

        $data = [
            'name'         => $this->faker->name,
            'second_name'  => $this->faker->lastName,
            'phone_number' => $this->faker->e164PhoneNumber,
            'country_code' => $countryCode->country_name,
            'timezone'     => $timeZone->name,
        ];

        $this->putJson(route('phone-book.update', ['phone_book' => $phoneBook->id]), $data)->assertOk()
            ->assertExactJson($phoneBook->fresh()->toArray());
        $this->assertDatabaseHas('phone_book', array_merge($data, ['country_code' => $countryCode->cca2]));
    }

    /**
     * Testing phone-book.destroy method.
     *
     * @return void
     */
    public function test_destroy(): void
    {
        /** @var PhoneBook $phoneBook */
        $phoneBook = PhoneBook::factory()->create();

        $this->deleteJson(route('phone-book.destroy', ['phone_book' => $phoneBook->id]))->assertNoContent();
        $this->assertDatabaseMissing('phone_book', ['id' => $phoneBook->id]);
    }
}
