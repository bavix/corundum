<?php

namespace App\Http\Api;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;

abstract class BaseController extends Controller
{

    /**
     * @var string
     */
    protected $defaultSort = 'id';

    /**
     * @return Builder
     */
    abstract protected function query(): Builder;

    /**
     * @return QueryBuilder
     */
    protected function queryBuilder(): QueryBuilder
    {
        return QueryBuilder::for($this->query())
            ->defaultSort($this->defaultSort);
    }

}
