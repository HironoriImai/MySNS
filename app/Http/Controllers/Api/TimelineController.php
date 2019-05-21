<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Tweet;

class TimelineController extends Controller
{
    public function showAllUserTimeline(Request $request){
    	$tweets = Tweet::getTheOtherUsersTweetById($request->user()->id);
    	$count = ($tweets===null)? 0: $tweets->count();
    	$tweets = ($tweets===null)? []: $tweets->toArray();
    	return [
    		'error' => 0,
    		'count' => $count,
    		'tweets' => $tweets,
    	];
    }
    public function showTimeline(Request $request){
    	$tweets = Tweet::getFollowUsersTweetById($request->user()->id);
        $count = ($tweets===null)? 0: $tweets->count();
    	$tweets = ($tweets===null)? []: $tweets->toArray();
    	return [
    		'error' => 0,
    		'count' => $count,
    		'tweets' => $tweets,
    	];
    }
}
