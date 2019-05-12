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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// ユーザのページ
Route::get('/@{username}', 'UserPageController@showUserPage');

// タイムラインの表示
Route::get('/timeline', 'TimelineController@showTimelinePage');

// ツイートの操作
Route::post('/tweet/post', 'TweetController@postTweet');
Route::post('/tweet/edit', 'TweetController@editTweet');
Route::post('/tweet/delete', 'TweetController@deleteTweet');