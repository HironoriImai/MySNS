<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Follow;
use \App\User;

class FollowController extends Controller
{
    // ユーザをフォローする
    public function followUser(Request $request){
        Follow::follow( $request->user()->id, User::getUserInfoFromUsername($request->username)->id );
        return [
            'error' => 0,
        ];
    }

    // ユーザのフォローを解除する
    public function unfollowUser(Request $request){
        Follow::unfollow( $request->user()->id, User::getUserInfoFromUsername($request->username)->id );
        return [
            'error' => 0,
        ];
    }
}
