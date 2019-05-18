<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\User;

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
        $api_token = Auth::user()->api_token;
        return view('home', compact(['api_token']));
    }

    // api_tokenの生成
    public function generateApiToken(){
        // api_tokenの生成
        User::generateApiToken(Auth::user()->id);
        
        // 元のページに戻る
        return back();
    }
}
