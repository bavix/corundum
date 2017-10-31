<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Bavix\Helpers\JSON;
use Bavix\Helpers\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Bavix\App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ImageController extends Controller
{

    /**
     * @param Request $request
     *
     * @return Image
     */
    protected function model(Request $request): Image
    {
        $user = $request->user();
        $name = $request->input('name');

        \abort_if(!$name, 400, 'The `name` parameter isn\'t found');

        $model = Image::findByName($user->login, $name);
        \abort_if(!$model, 404, 'Image not found');

        return $model;
    }

    public function upload(Request $request)
    {
        /**
         * @var $file \Illuminate\Http\UploadedFile
         */
        $user = $request->user();
        $file = $request->file('file');
        \abort_if(!$file, 400, 'The file parameter is empty');

        $mime = $file->getMimeType();
        $ext  = $file->extension() ?: $file->clientExtension();
        \abort_if(0 !== strpos($mime, 'image/'), 400, 'Unknown mime-type');

        $basename = Image::generateName($user->login, $ext);
        $fullPath = Image::realPath($user->login, $basename);

        $file->move(dirname($fullPath), $basename);

        $image          = new Image();
        $image->user    = $user->login;
        $image->name    = $basename;
        $image->mime    = $mime;
        $image->size    = $file->getSize() ?: $file->getClientSize();
        $image->user_id = $user->id;

        \abort_if(!$image->save(), 500, 'It wasn\'t succeeded to keep model');

        return Response::create($image, 201);
    }

    /**
     * @param Request $request
     *
     * @return $this
     */
    public function update(Request $request)
    {
        return $this->model($request)->regenerate();
    }

    /**
     * @param Request $request
     *
     * @throws \Exception
     */
    public function delete(Request $request)
    {
        $model = $this->model($request);
        \abort_if($model->delete(), 204);
        \abort(500);
    }

}
