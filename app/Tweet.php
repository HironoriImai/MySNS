<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable = [
    	'user_id', 'tweet_body',
    ];

    // ツイートの投稿
    public static function newTweet($user_id, $tweet_body){
    	self::create([
    		'user_id'	=> Auth::user()->id,
    		'tweet_body'=> $request->tweet_body,
    	]);
    }

    // ユーザ名（一意な文字列）からそのユーザのツイートを取得する
    public static function getTweetsByUsername($username){
    	return self::select('*', 'tweets.id as tweet_id')
    			->leftJoin('users', 'tweets.user_id', '=', 'users.id')
    			->where('name', $username)->get();
    }
}
