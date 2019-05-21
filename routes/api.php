<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>'api'], function(){
	// タイムラインの表示
	Route::middleware('auth:api')->post('/timeline_all_user', 'Api\TimelineController@showAllUserTimeline');
	Route::middleware('auth:api')->post('/timeline', 'Api\TimelineController@showTimeline');

	// ツイートの操作
	Route::middleware('auth:api')->post('/tweet/post', 'Api\TweetController@postTweet');
	Route::middleware('auth:api')->post('/tweet/edit', 'Api\TweetController@editTweet');
	Route::middleware('auth:api')->post('/tweet/delete', 'Api\TweetController@deleteTweet');

	// フォロー・フォロー解除
	Route::middleware('auth:api')->post('/follow', 'Api\FollowController@followUser');
	Route::middleware('auth:api')->post('/unfollow', 'Api\FollowController@unfollowUser');	
});