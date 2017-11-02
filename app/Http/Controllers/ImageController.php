<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Bavix\App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ImageController extends Controller
{

    /**
     * @param Request $request
     * @param string  $name
     *
     * @return Image
     */
    protected function model(Request $request, $name): Image
    {
        $user = $request->user();
        \abort_if(empty($name), 400, 'The `name` parameter isn\'t found');

        $model = Image::findByName($user->login, $name);
        \abort_if(!$model, 404, 'Image not found');

        return $model;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function upload(Request $request): Response
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
     * @param string  $name
     *
     * @return mixed
     */
    public function update(Request $request, $name)
    {
        return $this->model($request, $name)
            ->doRegenerate(
                $request->input('checkExists', false)
            );
    }

    /**
     * @param Request $request
     * @param string  $name
     *
     * @throws \Exception
     */
    public function delete(Request $request, $name)
    {
        $model = $this->model($request, $name);
        \abort_if($model->delete(), 204);
        \abort(500);
    }

}
