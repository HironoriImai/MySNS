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
    		'user_id'	=> $user_id,
    		'tweet_body'=> $tweet_body,
    	]);
    }

    // ツイートの編集
	public static function editTweet($user_id, $tweet_id, $tweet_body){
		$tweet = self::getTweet($user_id, $tweet_id);
		// 結果が存在した時
		if($tweet->count()>0){
			$tweet->fill(['tweet_body' => $tweet_body])->save();
		}
	}

	// ツイートの削除
    public static function deleteTweet($user_id, $tweet_id){
		$tweet = self::getTweet($user_id, $tweet_id);
		// 結果が存在した時
		if($tweet->count()>0){
			$tweet->delete();
		}
    }

    public static function getTweet($user_id, $tweet_id){
    	return self::where('id', $tweet_id)->where('user_id', $user_id)->first();
    }


    // ユーザ名（一意な文字列）からそのユーザのツイートを取得する
    public static function getTweetsByUsername($username){
    	return self::select('*', 'tweets.id as tweet_id')
    			->leftJoin('users', 'tweets.user_id', '=', 'users.id')
    			->where('name', $username)->get();
    }
}
