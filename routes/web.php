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
    $type = ".$type";
    if ($type !== '.webp') {
        $type = '';
    }

    \header("X-Accel-Redirect: /stream/$bucket/$view/$uuid$type");
    die;
})->where([
    'bucket' => '[a-z0-9]+',
    'view' => '[a-z0-9]+',
    'uuid' => '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}',
    'type' => '(png|webp)'
]);
