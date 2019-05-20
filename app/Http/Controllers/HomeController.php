<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\User;
use \App\Tweet;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // ユーザのツイート一覧
        $tweets = Tweet::getTweetsByUserId(Auth::user()->id);
        // apiトークン
        $api_token = Auth::user()->api_token;
        // 自己紹介文
        $self_introduction = Auth::User()->self_introduction;
        return view('home', compact(['api_token', 'self_introduction', 'tweets']));
    }

    // api_tokenの生成
    public function generateApiToken(){
        // api_tokenの生成
        User::generateApiToken(Auth::user()->id);
        
        // 元のページに戻る
        return back();
    }

    // 自己紹介文の登録
    public function registerSelfIntroduction(Request $request){
        // POST内容の検証
        $validator = $request->validate([
            'self_introduction' => ['required', 'string', 'max:1000'],
        ]);

        // 自己紹介文を登録
        User::setSelfIntroduction(Auth::user()->id, $request->self_introduction);

        // 元のページに戻る
        return back();
    }
}
