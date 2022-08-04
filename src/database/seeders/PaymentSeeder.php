<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Payment::factory()->create(
            [
                'uuid' => "3ce8dd8d-0416-300b-bf11-e02d37b6c34d"
            ]
        );
        \App\Models\Payment::factory()->create(
            [
                'uuid' => "b0691c9f-ff47-33bf-a9dd-a7ca6077dc17"
            ]
        );
        \App\Models\Payment::factory()->create(
            [
                'uuid' => "ca149cd3-dc20-3bd9-a7c7-e7ac34b38020"
            ]
        );
        \App\Models\Payment::factory(10)->create();
    }
}
