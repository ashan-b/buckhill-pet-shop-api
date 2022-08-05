<?php

namespace Tests\Feature\Controllers\Api\V1\OrderController;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderDownloadTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test order download
     *
     * @return void
     */
    public function test_order_download()
    {
        //Create a login request to get the auth token
        $loginResponse = $this->postJson('/api/v1/user/login', ['email' => 'user@gmail.com', 'password' => 'password']);
        //Create a order store request.
        $responseCreate = $this->withHeaders(
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $loginResponse['data']['token'],
            ]
        )->postJson(
            '/api/v1/order/create',
            [
                'order_status_uuid' => "41c92f2b-2d6d-34e3-a792-9e80d3ae4bc3",
                'payment_uuid' => "ca149cd3-dc20-3bd9-a7c7-e7ac34b38020",
                'products' => json_encode(
                    [
                        "uuid" => "2a6eacf2-7c97-3519-976d-a7989d7b138d",
                        "quantity" => 1
                    ]
                ),
                'address' => json_encode(
                    [
                        "billing" => "Billing Address",
                        "shipping" => "Shipping Address"
                    ]
                )
            ]
        );

        $responseCreate
            //Check if response status is 200
            ->assertStatus(200)
            //Check if response has data
            ->assertJsonStructure(
                [
                    'data' => [
                        'order' => [
                            'uuid',
                            'user_uuid',
                            'order_status_uuid',
                            'products',
                            'address',
                            'delivery_fee',
                            'amount',
                            'payment_uuid'
                        ]
                    ]
                ]
            )
            //Check if response structure is correct
            ->assertJson(
                [
                    'success' => true,
                    'data' => [
                        'order' => [
                            'products' => [
                                [
                                    "uuid" => "2a6eacf2-7c97-3519-976d-a7989d7b138d",
                                    "quantity" => 1
                                ]
                            ]
                        ]
                    ]
                ]
            );

        //Check expected pdf
        $expected_pdf_name = 'order_' . $responseCreate['data']['order']['uuid'] . '.pdf';
        $downloadResponse = $this->call(
            'GET',
            '/api/v1/order/' . $responseCreate['data']['order']['uuid'] . '/download',
            [
                'Authorization' => 'Bearer ' . $loginResponse['data']['token']
            ]
        );

        $downloadResponse = $this->get(
            '/api/v1/order/' . $responseCreate['data']['order']['uuid'] . '/download',
            ['Authorization' => 'Bearer ' . $loginResponse['data']['token']]
        );

        $this->assertTrue($downloadResponse->headers->get('content-type') == 'application/pdf');
        $this->assertTrue(
            $downloadResponse->headers->get(
                'content-disposition'
            ) == 'attachment; filename="' . $expected_pdf_name . '"'
        );
    }
}
