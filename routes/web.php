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

use App\Match;
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman/tinker', 'BotManController@tinker');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/schedule', function () {
    $matchs = [];
    foreach (Match::all() as $item) {
        if (strtotime($item->start_at . " " . $item->time) >= strtotime(Carbon::now()->toDateTimeString()) ) {
            $matchs[] = $item;
        }
    }

    return $matchs;
});
