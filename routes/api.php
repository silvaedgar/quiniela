<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchupApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a grRoute::group(['middleware' => 'auth'], function () {
oup which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('positions', [MatchupApiController::class,'positions']);
Route::post('process-goal', [MatchupApiController::class,'processGoal']);
Route::get('predicciones', [MatchupApiController::class,'predicciones']);

// Route::group(['middleware' => 'auth'], function () {
//     Route::get('init-matchup/{id}', [MatchupController::class,'initMatchup'])->name('matchup.init');
// });
