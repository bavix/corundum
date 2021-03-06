<?php

namespace App\Http\Api;

use App\Enums\Image\ImageFormatsEnum;
use App\Http\Requests\ViewRequest;
use App\Models\Bucket;
use App\Models\Image;
use App\Models\View;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ViewController extends BaseController
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
     * @param string $viewName
     * @return Image
     */
    public function show(Request $request, string $name, string $viewName): View
    {
        $bucket = Bucket::whereName($name)
            ->firstOrFail();

        return $this->queryBuilder()
            ->where('name', $viewName)
            ->where('bucket_id', $bucket->id)
            ->where('user_id', $this->getUser()->id)
            ->firstOrFail();
    }

    /**
     * @param ViewRequest $request
     * @param string $name
     * @return View
     */
    public function store(ViewRequest $request, string $name): View
    {
        $bucket = Bucket::whereName($name)->firstOrFail();
        $this->getUser()
            ->buckets()
            ->findOrFail($bucket->id);

        $view = new View();
        $view->bucket_id = $bucket->id;
        $view->user_id = $this->getUser()->id;
        $view->name = $request->input('name');
        $view->format = $request->input('format', ImageFormatsEnum::PNG);
        $view->type = $request->input('type');
        $view->width = $request->input('width');
        $view->height = $request->input('height');
        $view->color = $request->input('color');
        $view->quality = $request->input('quality');
        $view->optimize = (bool)$request->input('optimize', 0);
        $view->webp = (bool)$request->input('webp', 0);

        try {
            \abort_if(!$view->save(), 422);
        } catch (\Throwable $throwable) {
            \abort(422);
        }

        return $view;
    }

    /**
     * @param Request $request
     * @param string $name
     * @param string $viewName
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, string $name, string $viewName): Response
    {
        $bucket = Bucket::whereName($name)
            ->firstOrFail();

        /**
         * @var Image $view
         */
        $view = $this->getUser()
            ->views()
            ->where('bucket_id', $bucket->id)
            ->where('name', $viewName)
            ->firstOrFail();

        if (!$view) {
            \abort(422);
        }

        $view->delete();
        return response()->noContent();
    }

    /**
     * @return Builder
     */
    protected function query(): Builder
    {
        return $this->getUser()
            ->views()
            ->getQuery();
    }

}
