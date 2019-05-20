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
    	return [
    		'error' => 0,
    		'count' => $tweets->count(),
    		'tweets' => $tweets->toArray(),
    	];
    }
}
