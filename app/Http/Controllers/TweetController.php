<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Tweet;

class TweetController extends Controller
{
    // ツイートの投稿
    public function postTweet(Request $request){
    	// POST内容の検証
    	$validator = $request->validate([
    		'tweet_body' => ['required', 'string', 'max:140'],
    	]);
    	
    	// 新しいツイート
    	Tweet::postTweet(Auth::user()->id, $request->tweet_body);

    	// 元のページに戻る
		return back();
    }

    // ツイートの編集
    public function editTweet(Request $request){
    	// POST内容の検証
    	$validator = $request->validate([
    		'tweet_id' => ['required', 'integer'],
    		'tweet_body' => ['required', 'string', 'max:140'],
    	]);

    	// ツイートを編集
    	Tweet::editTweet(Auth::user()->id, $request->tweet_id, $request->tweet_body);

    	// 元のページに戻る
		return back();
    }

    // ツイートの削除
    public function deleteTweet(Request $request){
    	// POST内容の検証
    	$validator = $request->validate([
    		'tweet_id' => ['required', 'integer'],
    	]);

    	// ツイートを削除
    	Tweet::deleteTweet(Auth::user()->id, $request->tweet_id);

    	// 元のページに戻る
		return back();
    }


}
