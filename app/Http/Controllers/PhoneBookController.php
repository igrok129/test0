<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneBook\IndexRequest;
use App\Http\Requests\PhoneBook\StoreRequest;
use App\Http\Requests\PhoneBook\UpdateRequest;
use App\Http\Resources\PhoneBook\ListResource;
use App\Models\PhoneBook;
use App\Repositories\PhoneBookRepository;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PhoneBookController extends Controller
{
    public function __construct(private PhoneBookRepository $phoneBookRepository)
    {
    }

    /**
     * Listing phonebook.
     *
     * @param IndexRequest $request
     *
     * @return JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        return response()->json(ListResource::collection($this->phoneBookRepository->getList($request)));
    }

    /**
     * Creating new row in phonebook.
     *
     * @param StoreRequest $request
     *
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        PhoneBook::query()->create($request->validated());

        return response()->json(['status' => 'success'], Response::HTTP_CREATED);
    }

    /**
     * Getting specific row from phonebook.
     *
     * @param PhoneBook $phoneBook
     *
     * @return JsonResponse
     */
    public function show(PhoneBook $phoneBook): JsonResponse
    {
        return response()->json($phoneBook->toArray());
    }

    /**
     * Updating specific row in phonebook.
     *
     * @param UpdateRequest $request
     * @param PhoneBook     $phoneBook
     *
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, PhoneBook $phoneBook): JsonResponse
    {
        $phoneBook->update($request->validated());

        return response()->json($phoneBook);
    }

    /**
     * Deleting specific row from phonebook.
     *
     * @param PhoneBook $phoneBook
     *
     * @return JsonResponse
     */
    public function destroy(PhoneBook $phoneBook): JsonResponse
    {
        $phoneBook->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
