<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;

// bucket
Route::apiResource('bucket', 'BucketController')
    ->middleware('auth:api');

// image
Route::apiResource('bucket/{bucket}/image', 'ImageController')
    ->middleware('auth:api');

// file
Route::apiResource('bucket/{bucket}/file', 'FileController')
    ->middleware('auth:api');

// view
Route::apiResource('bucket/{bucket}/view', 'ViewController')
    ->middleware('auth:api');
