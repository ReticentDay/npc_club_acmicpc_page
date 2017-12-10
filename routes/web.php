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

Route::get('/','rootController@showProfile')->name('home');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcom');


Route::get('/console','rootController@console')->name('consoleIndex');
Route::post('/console/{id}/modify','rootController@modify');
Route::post('/console/AddCCoin','rootController@AddCCoin');
Route::post('/console/reset/season','rootController@reset');


Route::group(['prefix' => 'news'],function(){
    Route::get('/','NewsController@newsList')->name('newsList');
    Route::get('/show','NewsController@showNews')->name('showNews');
    Route::post('/to_add_news','NewsController@toAddNews');
    Route::post('/delete','NewsController@toDeleteNews');
    Route::get('/add_news','NewsController@addNews')->name('addNews');
});

Route::resource('/comprtition', 'CompritionController');
Route::post('/comprtition/{id}/add','CompritionController@addInfo');
Route::post('/comprtition/{id}/Settlement','CompritionController@settlement');
Route::post('/comprtition/{id}/save','CompritionController@save');
Route::post('/comprtition/{id}/vote','CompritionController@vote');

Route::resource('community', 'CommunityController');
Route::get('/community/{find_type}/search','CommunityController@search');
Route::post('/community/{id}/like','CommunityController@like');
Route::post('/community/{id}/reply','CommunityController@reply');

Route::get('/info','rootController@info');

Route::get('/show',function(){
    return Auth::user()->name;
});

Auth::routes();

Route::get('/home', 'HomeController@index');
