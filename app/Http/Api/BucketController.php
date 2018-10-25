<?php

namespace App\Http\Api;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
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
        $bucket = Bucket::whereName($name)
            ->firstOrFail();

        $queryBuilder = QueryBuilder::for(
            Image::query()
                ->where('user_id', $this->getUser()->id)
                ->where('bucket_id', $bucket->id)
        );

        return $queryBuilder->paginate();
    }

    /**
     * @param Request $request
     * @return Bucket|\Illuminate\Database\Eloquent\Model
     */
    public function store(Request $request)
    {
        /**
         * @var Bucket $bucket
         */
        $bucket = Bucket::firstOrCreate([
            'name' => $request->input('name')
        ]);

        try {
            $this->getUser()
                ->buckets()
                ->attach($bucket->id);
        } catch (\Throwable $throwable) {
            abort(409);
        }

        return $bucket;
    }

    /**
     * @param Request $request
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, string $name): Response
    {
        $bucket = Bucket::whereName($name)
            ->firstOrFail();

        $results = $this->getUser()
            ->buckets()
            ->detach($bucket->id);

        if (!$results) {
            \abort(422);
        }

        return response()->noContent();
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
        return $user->buckets()->getQuery();
    }

}