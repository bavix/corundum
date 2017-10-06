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

Route::get('/', function () {
    return view('welcome');
});


//Route::get('/redirect', function () {
//
//
//    $query = http_build_query([
//        'client_id'     => 'client-id',
//        'redirect_uri'  => 'http://larapi.local/auth/callback',
//        'response_type' => 'code',
//        'scope'         => '',
//    ]);
//
//    return redirect('http://larapi.local/oauth/authorize?' . $query);
//
//});
//
//Route::get('/auth/callback', function (Request $request) {
//
//    $http = new GuzzleHttp\Client;
//
//    $response = $http->post('http://larapi.local/oauth/token', [
//        'form_params' => [
//            'grant_type'    => 'authorization_code',
//            'client_id'     => 'client-id',
//            'client_secret' => 'client-secret',
//            'redirect_uri'  => 'http://larapi.local/auth/callback',
//            'code'          => $request->code,
//        ],
//    ]);
//
//    return json_decode((string)$response->getBody(), true);
//
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
