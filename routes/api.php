<?php

use Illuminate\Http\Request;

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

//Route::middleware('client_credentials'/*'auth:api'*/)->get('/user', function (Request $request) {
//    return \App\Models\User::query()->first();
//});

Route::middleware('auth:api')->post('/verify', function (Request $request) {

    /**
     * @var \App\Models\User $user
     */
    $user = $request->user();

    return [
        'verify' => $user !== null
    ];

});

Route::middleware('auth:api')
    ->post('/image', 'ImageController@upload');

Route::middleware('auth:api')
    ->post('/image/{name}', 'ImageController@update');

Route::middleware('auth:api')
    ->delete('/image/{name}', 'ImageController@delete');
