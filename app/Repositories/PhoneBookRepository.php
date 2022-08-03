<?php

namespace App\Repositories;

use App\Models\PhoneBook;
use App\Repositories\Criteria\IdCriteria;
use App\Repositories\Criteria\NameCriteria;
use App\Repositories\Criteria\SecondNameCriteria;
use Czim\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PhoneBookRepository extends BaseRepository
{
    /**
     * Returns specified model class name.
     *
     * @return string
     */
    public function model(): string
    {
        return PhoneBook::class;
    }

    /**
     * Get filtered list of PhoneBook's rows.
     *
     * @param Request $request
     *
     * @return Collection
     */
    public function getList(Request $request): Collection
    {
        $this->pushCriteria(new IdCriteria($request->input('id')));
        $this->pushCriteria(new NameCriteria($request->input('name')));
        $this->pushCriteria(new SecondNameCriteria($request->input('second_name')));

        return $this->all();
    }
}
