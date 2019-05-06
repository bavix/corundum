<?php

namespace App\Http\Api;

use App\Corundum\Kit\Path;
use App\Http\Requests\ImageRequest;
use App\Jobs\ImageQueue;
use App\Models\Bucket;
use App\Models\Image;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use Illuminate\Http\Request;

class ImageController extends BaseController
{

    /**
     * @param Request $request
     * @param string $name
     * @return LengthAwarePaginator
     */
    public function index(Request $request, string $name): LengthAwarePaginator
    {
        $bucket = Bucket::whereName($name)
            ->firstOrFail();

        return $this->queryBuilder()
            ->where('bucket_id', $bucket->id)
            ->paginate();
    }

    /**
     * @param Request $request
     * @param string $name
     * @param string $uuid
     * @return Image
     */
    public function show(Request $request, string $name, string $uuid): Image
    {
        $bucket = Bucket::whereName($name)
            ->firstOrFail();

        return $this->queryBuilder()
            ->allowedIncludes('palette', 'views', 'eav')
            ->where('name', $uuid)
            ->where('bucket_id', $bucket->id)
            ->firstOrFail();
    }

    /**
     * @param ImageRequest $request
     * @param string $name
     * @return Image
     */
    public function store(ImageRequest $request, string $name): Image
    {
        $data = \explode('.', $name, 2);
        $bucketName = $data[0];
        $uuid = $data[1] ?? null;
        \abort_if($uuid && Image::whereName($uuid)->exists(), 409);
        $bucket = Bucket::whereName($bucketName)->firstOrFail();

        try {
            $this->getUser()
                ->buckets()
                ->findOrFail($bucket->id);
        } catch (\Throwable $throwable) {
            $this->getUser()
                ->buckets()
                ->attach($bucket->id);
        }

        $image = new Image(['name' => $uuid]);
        $image->bucket_id = $bucket->id;
        $image->user_id = $this->getUser()->id;

        $path = Path::physical($image);
        $file = $request->file('file');
        \abort_if(!$file->move(\dirname($path), \basename($path)), 422);
        $image->save();

        dispatch(new ImageQueue($image));

        return $image;
    }

    public function destroy(Request $request, string $name, string $uuid)
    {
        $bucket = Bucket::whereName($name)
            ->firstOrFail();

        /**
         * @var Image $image
         */
        $image = $this->getUser()
            ->images()
            ->where('bucket_id', $bucket->id)
            ->where('name', $uuid)
            ->firstOrFail();

        if (!$image) {
            \abort(422);
        }

        $image->delete();
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
        return $user->images()->getQuery();
    }

}
