<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UrlApiController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*--------------------------- Customer APIs -----------------------------*/
Route::group(['prefix' => 'v1'], function () {
    // dd(request());
    /*--------------------------- access user all links ---------------------------*/
    Route::get('urls', [UrlApiController::class, 'getAllLink']);

    /*--------------------------- Shorten Url ---------------------------*/
    Route::post('shorten/url', [UrlApiController::class, 'shortenUrl']);

});
