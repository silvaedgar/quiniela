<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\MatchupController;
use App\Http\Controllers\Auth\LoginController;

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

Route::get('/home-guest', 'App\Http\Controllers\HomeController@homeGuest')->name('home-guest');

Route::get('/', function () {
    return redirect()->route('home-guest');
});

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')
    ->name('home')
    ->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

    Route::get('my-logout', [App\Http\Controllers\HomeController::class, 'myLogout'])->name('my-logout');

    Route::get('predictions/print/{player_id}', [PredictionController::class, 'print'])->name('predictions.print');
    Route::resource('predictions', PredictionController::class)->names('predictions');

    Route::get('players', [PlayerController::class, 'index'])->name('players.index');
    Route::get('players/position', [PlayerController::class, 'position'])->name('players.position');
    Route::get('players/print', [PlayerController::class, 'printPredictions'])->name('players.printPredictions');

    Route::get('activate', [PlayerController::class, 'activate'])->name('players.activate');
    Route::get('send-emails', [PlayerController::class, 'sendEmail'])->name('players.email');

    Route::post('store', [PlayerController::class, 'store'])->name('players.store');

    Route::get('results-live', [MatchupController::class, 'resultsLive'])->name('matchups.results-live');
    Route::get('results', [MatchupController::class, 'results'])->name('matchups.results');
    Route::get('close-date', [MatchupController::class, 'closeDate'])->name('matchups.close-date');
});
