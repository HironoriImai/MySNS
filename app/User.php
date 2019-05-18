<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'api_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'api_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    // ユーザの存在確認
    // 後々正規表現検索とかできるように条件式は 0より大きい にしとく
    public static function usernameExists($username){
        return self::where('name', $username)->count() > 0;
    }

    // api_tokenの作成
    public static function generateAPIToken($user_id){
        $api_token = null;
        $user = self::find((int)$user_id);
        // 結果が存在した時
        if($user->count()>0){
            // api_token（32文字の乱数）を発行
            $api_token = md5(uniqid(rand(), true));
            $user->update(['api_token' => $api_token]);
        }
        // api_token（$user_idが不正なときはnull）を返す
        return $api_token;
    }
}
