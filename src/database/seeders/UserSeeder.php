<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create(
            [
                'email' => 'user@gmail.com',
                'is_admin' => false
            ]
        );
        \App\Models\User::factory()->create(
            [
                'email' => 'admin@gmail.com',
                'is_admin' => true
            ]
        );

        \App\Models\User::factory(10)->create();
    }
}
