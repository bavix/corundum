<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::view('/', 'welcome')
    ->name('welcome');

Route::get('/dashboard', 'DashboardController@index')
    ->middleware('auth')
    ->name('dashboard');

Route::get('/{bucket}/{view}/{uuid}.{type}', function (string $bucket, string $view, string $uuid, string $type) {

    $modelBucket = new \App\Models\Bucket();
    $modelBucket->name = $bucket;

    $image = new \App\Models\Image();
    $image->name = $uuid;
    $image->setRelation('bucket', $modelBucket);

    $path = \App\Corundum\Kit\Path::relative($image, $view);

    $contentType = 'image/webp';
    $type = ".$type";
    if ($type !== '.webp') {
        $type = '';
        $contentType = 'image/png';
    }

    \header('Content-Type: ' . $contentType);
    \header("X-Accel-Redirect: /stream/$path$type");
    die;
})->where([
    'bucket' => '[a-z0-9]+',
    'view' => '[a-z0-9]+',
    'uuid' => '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}',
    'type' => '(png|webp)'
]);
