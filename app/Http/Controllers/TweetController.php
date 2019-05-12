<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 使用するユーザ定義モデル
use Illuminate\Support\Facades\Auth;
use \App\Tweet;

class TweetController extends Controller
{
    // ツイートの投稿
    public function postTweet(Request $request){
    	// POST内容の検証
    	$validator = $request->validate([
    		'tweet_body' => ['required', 'string', 'max:280'],
    	]);
    	
    	// DBに追加
    	Tweet::newTweet(Auth::user()->id, $request->tweet_body);

    	// 元のページに戻る
		return back();
    }

    // ツイートの編集
    public function editTweet(){

    }

    // ツイートの削除
    public function deleteTweet(){

    }


}
