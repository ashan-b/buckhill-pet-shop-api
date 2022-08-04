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
                'uuid' => "3ce8dd8d-0416-300b-bf11-e02d37b6c34d",
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
