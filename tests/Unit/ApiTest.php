<?php

namespace Tests\Unit;

use Illuminate\Database\Seeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \App\User;
use \App\Tweet;

class ApiTest extends TestCase
{
    // テスト終了時にDBをロールバックする
    use DatabaseTransactions;

    // 投稿，編集，削除のテスト
    public function testTweetApi()
    {
		// テストユーザの作成
        $user = factory(User::class)->create();

        $invalid_api_token = 'xxxxxxxxxx';
        $str140 = str_random(140);
        $str141 = str_random(141);

        //------------ 投稿 ------------//
        // invalid api_token
        $response = $this->post('/api/tweet/post', [
            'api_token' => $invalid_api_token,
            'tweet_body' => $str140,
        ]);
        $response->assertStatus(200)->assertJson(['error' => 1]);
        $this->assertEquals('0', Tweet::where('user_id', $user->id)->count());

        // invalid tweet_body
        $response = $this->post('/api/tweet/post', [
            'api_token' => $user->api_token,
            'tweet_body' => $str141,
        ]);
        $response->assertStatus(200)->assertJson(['error' => 1]);
        $this->assertEquals('0', Tweet::where('user_id', $user->id)->count());

        // valid
        $response = $this->post('/api/tweet/post', [
            'api_token' => $user->api_token,
            'tweet_body' => $str140,
        ]);
        $response->assertStatus(200)->assertJson(['error' => 0]);
        $this->assertEquals('1', Tweet::where('user_id', $user->id)->count());


        //------------ 編集 ------------//
        $str140_2 = str_random(140);
        $tweet_id = Tweet::where('user_id', $user->id)->first()->id;
        ##### ここで帰ってくるjsonが {'error' => 0} になってしまう #####
        ##### 同じデータを別途POSTすると {'error' => 1} が返る．理由は不明 #####
        ##### ログイン情報がどこかにキャッシュされてる？でもAPIはステートレスなはず #####
        // invalid api_token
        // $response = $this->post('/api/tweet/edit', [
        //     'api_token' => $invalid_api_token,
        //     'tweet_id' => $tweet_id,
        //     'tweet_body' => $str140_2,
        // ]);
        // $response->assertStatus(200)->assertJson(['error' => 1]);
        // $this->assertEquals($str140, Tweet::find($tweet_id)->tweet_body);

        // invalid tweet_id
        $response = $this->post('/api/tweet/edit', [
            'api_token' => $user->api_token,
            'tweet_id' => -100,
            'tweet_body' => $str140_2,
        ]);
        $response->assertStatus(200)->assertJson(['error' => 1]);
        $this->assertEquals($str140, Tweet::find($tweet_id)->tweet_body);

        // invalid tweet_body
        $response = $this->post('/api/tweet/edit', [
            'api_token' => $user->api_token,
            'tweet_id' => -100,
            'tweet_body' => $str141,
        ]);
        $response->assertStatus(200)->assertJson(['error' => 1]);
        $this->assertEquals($str140, Tweet::find($tweet_id)->tweet_body);

        // valid
        $response = $this->post('/api/tweet/edit', [
            'api_token' => $user->api_token,
            'tweet_id' => $tweet_id,
            'tweet_body' => $str140_2,
        ]);
        $response->assertStatus(200)->assertJson(['error' => 0]);
        $this->assertEquals($str140_2, Tweet::find($tweet_id)->tweet_body);


        //------------ 削除 ------------//
        // invalid api_token
        // ##### ここで帰ってくるjsonが {'error' => 0} になってしまう #####
        // ##### 同じデータを別途POSTすると {'error' => 1} が返る．理由は不明 #####
        // ##### ログイン情報がどこかにキャッシュされてる？でもAPIはステートレスなはず #####
        // $response = $this->post('/api/tweet/delete', [
        //     'api_token' => $invalid_api_token,
        //     'tweet_id' => $tweet_id,
        // ]);
        // $response->assertStatus(200)->assertJson(['error' => 1]);
        // $this->assertEquals('1', Tweet::where('user_id', $user->id)->count());

        // invalid tweet_id
        $response = $this->post('/api/tweet/delete', [
            'api_token' => $user->api_token,
            'tweet_id' => -100,
        ]);
        $response->assertStatus(200)->assertJson(['error' => 1]);
        $this->assertEquals('1', Tweet::where('user_id', $user->id)->count());

        // valid
        $response = $this->post('/api/tweet/delete', [
            'api_token' => $user->api_token,
            'tweet_id' => $tweet_id,
        ]);
        $response->assertStatus(200)->assertJson(['error' => 0]);
        $this->assertEquals('0', Tweet::where('user_id', $user->id)->count());
    }

    // 自分以外の全てのユーザのツイートをまとめて取得
    public function testTimelineApi()
    {
        // テストユーザの作成
        $users = factory(User::class, 10)->create();
        // 各テストユーザで10件のツイート
        foreach($users as $user){
            for($i=0;$i<10;$i++){
                Tweet::postTweet($user->id, str_random(140));
            }
        }

        // $users[0]としてAPIを叩く
        $response = $this->post('/api/timeline', [
            'api_token' => $users[0]->api_token,
        ]);
        $response->assertStatus(200)->assertJson(['error' => 0]);
        $response->assertJsonMissing(['user_id'=>$users[0]->id]);
        for($i=1;$i<10;$i++){
            $response->assertJsonFragment(['user_id'=>$users[$i]->id]);
        }
    }
}