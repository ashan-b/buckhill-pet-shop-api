<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class UserCreateTest extends TestCase
{

    use RefreshDatabase;

    public function test_user_create()
    {
        //Generate user data from Factory
        $user = User::factory()->make(
            [
                'email' => 'testcreateuser@gmail.com',
                'is_admin' => false
            ]
        )->toArray();

        //Make the post request to create the user
        $response = $this->postJson(
            '/api/v1/user/create',
            $user
        );

        //Check the json response
        $response
            //Check if response status is 200
            ->assertStatus(200)
            //Check the response data structure
            ->assertJsonStructure(
                [
                    'data' => [
                        'uuid',
                        'first_name',
                        'last_name',
                        'email',
                        'avatar',
                        'address_title',
                        'address_line_1',
                        'address_line_2',
                        'address_line_3',
                        'address_line_4_city',
                        'address_line_5_state',
                        'address_line_6_zip',
                        'address_line_7_country',
                        'phone_number_country_code',
                        'phone_number',
                        'is_marketing',
                        'updated_at',
                        'created_at',
                        'token',
                    ]
                ]
            )
            //Check if response is success
            ->assertJson(
                [
                    'success' => true
                ]
            );

        //Check database
        $this->assertDatabaseHas(
            'users',
            [
                'email' => 'testcreateuser@gmail.com',
            ]
        );
    }
}
