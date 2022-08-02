<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create(
            [
                'title' => 'canceled',
                'uuid' => '56e42c2d-1311-3f8f-b670-6ebe1ff50768'
            ]
        );

        OrderStatus::create(
            [
                'title' => 'shipped',
                'uuid' => 'd2c9b721-13c3-35ba-a0b5-10e683958608'
            ]
        );

        OrderStatus::create(
            [
                'title' => 'paid',
                'uuid' => '41c92f2b-2d6d-34e3-a792-9e80d3ae4bc3'
            ]
        );

        OrderStatus::create(
            [
                'title' => 'pending payment',
                'uuid' => 'c1229f0c-af35-3a36-8c9b-a54830529a52'
            ]
        );

        OrderStatus::create(
            [
                'title' => 'open',
                'uuid' => '8fe0053a-6bbe-34e7-820f-19812a6e62e5'
            ]
        );
    }
}
