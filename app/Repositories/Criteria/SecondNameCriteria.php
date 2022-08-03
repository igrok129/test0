<?php

namespace App\Repositories\Criteria;

use App\Models\PhoneBook;
use Czim\Repository\Contracts\BaseRepositoryInterface;
use Czim\Repository\Contracts\CriteriaInterface;
use Czim\Repository\Contracts\ExtendedRepositoryInterface;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as DatabaseBuilder;

class SecondNameCriteria implements CriteriaInterface
{
    public function __construct(private ?string $secondName)
    {
    }

    /**
     * Apply condition to query.
     *
     * @param Model|DatabaseBuilder|EloquentBuilder|PhoneBook     $model
     * @param BaseRepositoryInterface|ExtendedRepositoryInterface $repository
     *
     * @return DatabaseBuilder|EloquentBuilder
     */
    public function apply($model, BaseRepositoryInterface|ExtendedRepositoryInterface $repository): DatabaseBuilder|EloquentBuilder
    {
        if ($this->secondName === null) {
            return $model->newQuery();
        }

        return $model->newQuery()->whereSecondName($this->secondName);
    }
}
