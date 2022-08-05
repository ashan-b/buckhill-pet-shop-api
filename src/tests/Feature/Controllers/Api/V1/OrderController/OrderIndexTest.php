<?php

namespace Tests\Feature\Controllers\Api\V1\OrderController;

use Tests\TestCase;

class OrderIndexTest extends TestCase
{
    /**
     * Test order listing
     *
     * @return void
     */
    public function test_order_index()
    {
        //Create a login request to get the auth token
        $loginResponse = $this->postJson('/api/v1/user/login', ['email' => 'user@gmail.com', 'password' => 'password']);
        //Create a order index request.
        $response = $this->withHeaders(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginResponse['data']['token'],
            ]
        )->getJson('/api/v1/orders');

        $response
            //Check if response status is 200
            ->assertStatus(200)
            //Check if response has data
            ->assertJsonStructure(['data'])
            //Check if response is success
            ->assertJson(
                [
                    'success' => true
                ]
            );
    }
}
