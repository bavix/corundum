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

Route::get('/{bucket}/{view}/{uuid}.{type}', 'StreamController@image')
    ->name('stream.image')
    ->where([
        'bucket' => '[a-z0-9]+',
        'view' => '[a-z0-9]+',
        'uuid' => '[0-9a-fA-F]{8}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{4}\-[0-9a-fA-F]{12}',
        'type' => '(jpg|png|webp)'
    ]);

Route::get('/dashboard', 'DashboardController@index')
    ->middleware('auth')
    ->name('dashboard');
