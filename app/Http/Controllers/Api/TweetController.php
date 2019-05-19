<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Tweet;

class TweetController extends Controller
{
    // ツイートの投稿
    public function postTweet(Request $request){
    	// POST内容の検証
        // TODO: このvalidation毎回同じの書くからどっかでまとめたい
    	$validator = $request->validate([
    		'tweet_body' => ['required', 'string', 'max:140'],
    	]);
    	
    	// 新しいツイート
        Tweet::postTweet($request->user()->id, $request->tweet_body);

    	// 応答json
		return ['error'=>0];
    }

    // ツイートの編集
    public function editTweet(Request $request){
    	// POST内容の検証
    	$validator = $request->validate([
    		'tweet_id' => ['required', 'integer'],
    		'tweet_body' => ['required', 'string', 'max:140'],
    	]);
        
        // ツイートを編集
    	Tweet::editTweet($request->user()->id, $request->tweet_id, $request->tweet_body);

    	// 応答json
		return ['error'=>0];
    }

    // ツイートの削除
    public function deleteTweet(Request $request){
    	// POST内容の検証
    	$validator = $request->validate([
    		'tweet_id' => ['required', 'integer'],
    	]);

    	// ツイートを削除
    	Tweet::deleteTweet($request->user()->id, $request->tweet_id);

    	// 応答json
		return ['error'=>0];
    }


}
