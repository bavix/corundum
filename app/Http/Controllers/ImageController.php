<?php

namespace App\Http\Controllers;

use App\Corundum\Kit\Path;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageController extends Controller
{

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $relations = [Image::REL_BUCKET];
        $image = Image::whereUserId(1)
            ->with($relations);

        return ImageResource::collection($image->paginate());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return ImageResource
     */
    public function show($id)
    {
        return new ImageResource($this->image($id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageRequest  $request
     * @param  int $bucketId
     *
     * @return JsonResponse
     */
    public function store(ImageRequest $request, int $bucketId): JsonResponse
    {
        /**
         * @var UploadedFile $file
         */
        $files = $request->files->get('file');

        $models = [];
        foreach ($files as $file) {
            $model = new Image();
            $model->user_id = 1;
            $model->bucket_id = $bucketId;
            $model->size = $file->getSize();
            $model->mime = $file->getMimeType();
            $path = Path::physical($model);
            if ($file->move(\dirname($path), $model->name)) {
                $model->save();
                $models[] = $model;
            }
        }

        return response()->json($models, 201);
    }

    /**
     * @param int $id
     *
     * @return Image
     */
    protected function image(int $id): Image
    {
        return Image::whereUserId(Auth::id())
            ->findOrFail($id);
    }

}
