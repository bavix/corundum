<?php

namespace App\Http\Controllers;

use App\Http\Resources\BucketResource;
use App\Models\Bucket;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class BucketController extends Controller
{

    public function getUser(): User
    {
        $user = Auth::getUser();

        /** debug */
        if (!$user) {
            $user = User::first();
        }
        /** /debug */

        return $user;
    }

    public function index(Request $request)
    {
        return BucketResource::collection(
            $this->getUser()->buckets()->paginate()
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
        $this->getUser()->buckets();
    }

}
