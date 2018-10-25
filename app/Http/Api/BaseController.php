<?php

namespace App\Http\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
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

    /**
     * @param Request $request
     * @throws
     */
    public function update(Request $request): void
    {
        \abort(405);
    }

    /**
     * @return User
     */
    protected function getUser(): User
    {
        return \auth()->user();
    }

}
