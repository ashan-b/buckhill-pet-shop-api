<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserLoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_login()
    {

        //Create a login request with known user details.
        $response = $this->postJson('/api/v1/user/login', ['email' => 'user@gmail.com', 'password' => 'password']);

        $response
            //Check if response status is 200
            ->assertStatus(200)
            //Check if response has data->token
            ->assertJsonStructure(['data' => ['token']])
            //Check if response is success
            ->assertJson(
            [
                'success' => true
            ]
        );;
    }
}
