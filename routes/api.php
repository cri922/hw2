<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeApiController;
use App\Http\Controllers\DatabaseApiController;

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

//returns a list of top anime from external website
Route::get('top',[AnimeApiController::class,'getTopAnime']);

//example to search an anime by name
// search?q=naruto
Route::get('search',[AnimeApiController::class,'searchAnimeByName']);

Route::get('anime/{id}', [AnimeApiController::class,'getAnimeInfoById'])->where('id','[0-9]+');
