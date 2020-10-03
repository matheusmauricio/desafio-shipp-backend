<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('V1')->middleware('registra_log')->group(function () {
    Route::get('stores', 'Api\StoreController@buscarLojas')->middleware('verifica_parametros');
    Route::get('stores/{latitude?}', 'Api\StoreController@buscarLojas')->middleware('verifica_parametros');
    Route::get('stores/{latitude?}/{longitude?}', 'Api\StoreController@buscarLojas')->middleware('verifica_parametros');
    Route::get('stores/{latitude?}/{longitude?}/{parametro3?}', 'Api\StoreController@buscarLojas')->middleware('verifica_parametros')->where('parametro3', '.*');
});
