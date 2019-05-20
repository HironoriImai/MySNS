<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    protected $fillable = [
    	'user_id', 'tweet_body',
    ];

    // ツイートの投稿
    public static function postTweet($user_id, $tweet_body){
    	self::create([
    		'user_id'	=> $user_id,
    		'tweet_body'=> $tweet_body,
    	]);
    }

    // ツイートの編集
	public static function editTweet($user_id, $tweet_id, $tweet_body){
		$tweet = self::getTweet($tweet_id, $user_id);
		// 結果が存在した時
		if($tweet->count()>0){
			$tweet->fill(['tweet_body' => $tweet_body])->save();
		}
	}

	// ツイートの削除
    public static function deleteTweet($user_id, $tweet_id){
		$tweet = self::getTweet($tweet_id, $user_id);
		// 結果が存在した時
		if($tweet->count()>0){
			$tweet->delete();
		}
    }

    // ツイートの取得
    public static function getTweet($tweet_id, $user_id = null){
        $tweet = self::find($tweet_id);
        // 当該ツイートは存在しない
        if($tweet===null){
            return null;
        }
        // ユーザIDが指定されていない
        if($user_id===null){
            return $tweet;
        }// ユーザIDが指定されている
        else{
            if($tweet->user_id===(int)$user_id){
                return $tweet;
            }else{
                return null;
            }
        }
    }


    // ユーザ名（一意な文字列）からそのユーザのツイートを取得する
    public static function getTweetsByUserId($user_id){
        return self::select('*', 'tweets.id as tweet_id')
                ->leftJoin('users', 'tweets.user_id', '=', 'users.id')
                ->where('user_id', $user_id)->orderBy('tweets.created_at', 'desc')->get();
    }

    // ユーザ名（一意な文字列）からそのユーザのツイートを取得する
    public static function getTweetsByUsername($username){
        return self::select('*', 'tweets.id as tweet_id')
                ->leftJoin('users', 'tweets.user_id', '=', 'users.id')
                ->where('name', $username)->orderBy('tweets.created_at', 'desc')->get();
    }

    // 自分以外のユーザのツイートを全て取得する
    public static function getTheOtherUsersTweetById($user_id){
		return self::where('user_id', '!=', $user_id)->orderBy('created_at', 'desc')->get();
    }
}
