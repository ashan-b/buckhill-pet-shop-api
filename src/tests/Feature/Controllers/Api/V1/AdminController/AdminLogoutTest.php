<?php

namespace Tests\Feature;

use App\Http\Traits\JwtTokenHelper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class AdminLogoutTest extends TestCase
{

    use JwtTokenHelper;


    public function test_admin_logout()
    {

        //Create a login request with known user details.
        $loginResponse = $this->postJson('/api/v1/admin/login', ['email' => 'admin@gmail.com', 'password' => 'password']);
        //Get the JWT token
        $jwtToken = $loginResponse->getData()->data->token;

        //Get the unique id from the token
        $parsedJwtToken = $this->parseJwtToken($jwtToken);
        $unique_id = $parsedJwtToken->claims()->get('unique_id');

        //Check if the jwt token is in the database.
        $this->assertDatabaseHas(
            'jwt_tokens',
            [
                'unique_id' => $unique_id,
            ]
        );

        //Create a logout request with Authorization header
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $jwtToken])->get(
            '/api/v1/admin/logout'
        );

        //Check if response status is 200
        $response->assertStatus(200);

        //Check if the jwt token is not in the database
        $this->assertDatabaseMissing(
            'jwt_tokens',
            [
                'unique_id' => $unique_id,
            ]
        );
    }
}
