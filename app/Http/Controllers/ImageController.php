<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImageController extends Controller
{

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $relations = [Image::REL_FORMATS, Image::REL_BUCKET];
        $image = Image::whereUserId(Auth::id())
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->files as $file) {
            // todo: dispatch(new ... (file))

        }
//            $product = Product::create($request->all());
//            return response()->json($product, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // todo

//        $product->update($request->all());
//        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // todo

//        $product->delete();
//        return response()->json(null, 204);
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
