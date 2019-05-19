<?php

namespace Tests\Unit;

use Illuminate\Database\Seeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use \App\User;
use \App\Tweet;

class HomeControllerTest extends TestCase
{

    // テスト終了時にDBをロールバックする
    use DatabaseTransactions;

    public function testCreateUser()
    {
		// $this->seed(__CLASS__ . 'Seeder');

		$user = factory(User::class)->create();
		
		$response = $this->actingAs($user);

		$response->get('/home')->assertSuccessful();
    }

}


// class ExampleTestSeeder extends Seeder
// {
//     public function run()
//     {
//         Tweet::->insert([

//         ]);
//     }
// }