<?php

namespace App\Http\Api;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Models\Bucket;
use App\Models\Image;
use App\Models\User;

class BucketController extends BaseController
{

    /**
     * @param Request $request
     *
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return $this->queryBuilder()->paginate();
    }

    /**
     * @param Request $request
     * @param string $name
     *
     * @return LengthAwarePaginator
     */
    public function show(Request $request, string $name): LengthAwarePaginator
    {
        $bucket = Bucket::whereName($name)->firstOrFail();

        $queryBuilder = QueryBuilder::for(
            Image::query()
                ->where('user_id', $request->user()->id)
                ->where('bucket_id', $bucket->id)
        );

        return $queryBuilder->paginate();
    }

    /**
     * @param Request $request
     * @param string $name
     */
    public function upload(Request $request, string $name): void
    {
        // upload file
        \abort(405);
    }

    /**
     * @param Request $request
     * @param string $name
     * @throws
     */
    public function store(Request $request, string $name): void
    {
        // create bucket
        \abort(405);
    }

    /**
     * @param Request $request
     * @param string $name
     * @throws
     */
    public function destroy(Request $request, string $name): void
    {
        // delete bucket
        \abort(405);
    }

    /**
     * @param Request $request
     * @param string $name
     * @throws
     */
    public function update(Request $request, string $name): void
    {
        \abort(405);
    }

    /**
     * @return Builder
     */
    protected function query(): Builder
    {
        /**
         * @var $user User
         */
        $user = \auth()->user();
        return $user->buckets();
    }

}
