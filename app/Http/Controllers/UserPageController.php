<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 使用するユーザ定義モデル
use \App\Tweet;
use \App\User;

class UserPageController extends Controller
{
    //ユーザページ（タイムライン含む）の表示
    public function showUserPage($username){
    	// ユーザが存在しない場合の例外処理
    	if(User::where('name', $username)->count() === 0){
    		// TODO: ユーザが存在しない場合の処理を作る
    		return '存在しないユーザです';
    	}
    	// ユーザのツイートを取得してつぶやきを表示
    	$tweets = Tweet::leftJoin('users', 'tweets.user_id', '=', 'users.id')
    						->where('name', $username)->get();
    	return view('userpage', compact(['username', 'tweets']));
    }
}
