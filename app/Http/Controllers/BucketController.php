<?php

namespace App\Http\Controllers;

use App\Http\Resources\BucketResource;
use App\Models\Bucket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class BucketController extends Controller
{

    public function index(Request $request)
    {
        return BucketResource::collection(
            Auth::user()->buckets()->paginate()
        );
    }

    public function show(int $id): BucketResource
    {
        $image = Bucket::find($id);

        return new BucketResource($image);
    }

    public function store(Request $request, int $bucketId): AnonymousResourceCollection
    {
        $bucket = Bucket::find($bucketId);
        Auth::user()->buckets();
    }

}
