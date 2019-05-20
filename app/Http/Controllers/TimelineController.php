<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Tweet;

class TimelineController extends Controller
{
    public function showAllUserTimelinePage(){
        $tweets = Tweet::getTheOtherUsersTweetById(Auth::user()->id);
        return view('timeline', compact('tweets'));
    }

    public function showTimelinePage(){
    	$tweets = Tweet::getFollowUsersTweetById(Auth::user()->id);
        return view('timeline', compact('tweets'));
    }
}
