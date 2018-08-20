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
            Bucket::findOrFail($id)
        );
    }

    /**
     * @param Request $request
     *
     * @return BucketResource
     */
    public function store(Request $request): BucketResource
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

        if (!$bucketExists) {
            $buckets->attach($object->id);
        }

        return new BucketResource($object);
    }

}
