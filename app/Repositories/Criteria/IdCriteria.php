<?php

namespace App\Repositories\Criteria;

use App\Models\PhoneBook;
use Czim\Repository\Contracts\BaseRepositoryInterface;
use Czim\Repository\Contracts\CriteriaInterface;
use Czim\Repository\Contracts\ExtendedRepositoryInterface;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as DatabaseBuilder;

class IdCriteria implements CriteriaInterface
{
    public function __construct(private ?int $id)
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
        if ($this->id === null) {
            return $model->newQuery();
        }

        return $model->newQuery()->whereId($this->id);
    }
}
