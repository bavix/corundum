<?php

namespace App\Http\Controllers;

use App\Http\Resources\BucketResource;
use App\Models\Bucket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class BucketController extends Controller
{

    /**
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return BucketResource::collection(
            Auth::user()->buckets()->paginate()
        );
    }

    /**
     * @param int $id
     *
     * @return BucketResource
     */
    public function show(int $id): BucketResource
    {
        return new BucketResource(
            Auth::user()->buckets()
                ->wherePivot('bucket_id', $id)
                ->firstOrFail()
        );
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $name = $request->input('name');

        /**
         * @var Model $object
         */
        $object = Bucket::query()
            ->firstOrCreate(\compact('name'));

        $buckets = Auth::user()->buckets();

        $bucketExists = $buckets
            ->wherePivot('bucket_id', $object->id)
            ->exists();

        $response = (new BucketResource($object))
            ->response();

        if (!$bucketExists) {
            $buckets->attach($object->id);

            return $response
                ->setStatusCode(201);
        }

        return $response
            ->setStatusCode(409);
    }

}
