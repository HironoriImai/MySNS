<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Tweet;
use \App\User;

class UserPageController extends Controller
{
    //ユーザページ（タイムライン含む）の表示
    public function showUserPage($username){
    	// ユーザが存在しない場合の例外処理
    	if(!($user = User::getUserInfoFromUsername($username))){
    		// TODO: ユーザが存在しない場合の処理を作る
    		return '存在しないユーザです';
    	}
        $self_introduction = $user->self_introduction;
    	// ユーザのツイートを取得してつぶやきを表示
    	$tweets = Tweet::getTweetsByUsername($user->name);
        $is_private = $user->is_private;
    	return view('userpage', compact(['username', 'self_introduction', 'is_private', 'tweets']));
    }
}
