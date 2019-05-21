<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\User;

class Follow extends Model
{
    protected $fillable = [
    	'follow_from', 'follow_to',
    ];

    // あるユーザをフォローしているかどうか
    public static function isFollowingUserById($user_id_from, $user_id_to){
        return self::where('follow_from', $user_id_from)->where('follow_to', $user_id_to)->count() > 0;
    }

    // あるユーザをフォローしているかどうか
    public static function isFollowingUserByName($username_from, $username_to){
    	return self::isFollowingUserById(
    			User::getUserInfoFromUsername($username_from)->id,
    			User::getUserInfoFromUsername($username_to)->id
    	);
    }

    public static function follow($user_id_from, $user_id_to){
    	self::create([
    		'follow_from' => $user_id_from,
    		'follow_to' => $user_id_to,
    	]);
    }

    public static function unfollow($user_id_from, $user_id_to){
    	$follow = self::where('follow_from', $user_id_from)->where('follow_to', $user_id_to);
		// 結果が存在した時
		if($follow->count()>0){
			$follow->delete();
		}
    }
}
