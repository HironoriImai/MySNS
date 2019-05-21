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

// ログインが必要
Route::group(['middleware' => 'auth'], function () {
    // マイページ画面
    Route::get('/home', 'HomeController@index')->name('home');
	Route::post('/home/generate_api_token', 'HomeController@generateApiToken');
	Route::post('/home/register_self_introduction', 'HomeController@registerSelfIntroduction');
	Route::post('/home/private_setting', 'HomeController@private_setting');

	// タイムラインの表示
	Route::get('/timeline_all_user', 'TimelineController@showAllUserTimelinePage');
	Route::get('/timeline', 'TimelineController@showTimelinePage');

	// ツイートの操作
	Route::post('/tweet/post', 'TweetController@postTweet');
	Route::post('/tweet/edit', 'TweetController@editTweet');
	Route::post('/tweet/delete', 'TweetController@deleteTweet');

	// フォロー・フォロー解除
	Route::post('/follow', 'FollowController@followUser');
	Route::post('/unfollow', 'FollowController@unfollowUser');
});

// ユーザのページ
Route::get('/@{username}', 'UserPageController@showUserPage');
