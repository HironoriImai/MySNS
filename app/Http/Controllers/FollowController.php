<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Follow;
use \App\User;

class FollowController extends Controller
{
    // ユーザをフォローする
    public static function followUser(Request $request){
        Follow::follow( Auth::user()->id, User::getUserInfoFromUsername($request->username)->id );
        return back();
    }

    // ユーザのフォローを解除する
    public static function unfollowUser(Request $request){
        Follow::unfollow( Auth::user()->id, User::getUserInfoFromUsername($request->username)->id );
        return back();
    }
}
