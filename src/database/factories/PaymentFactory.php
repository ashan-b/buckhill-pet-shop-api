<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $type = fake()->randomElement(['bank_transfer', 'cash_on_delivery', 'credit_card']);
        $details = [];

        if($type==="bank_transfer"){
            $details = [
                'swift'=> fake()->swiftBicNumber(),
                'iban'=> fake()->iban(),
                'name'=> fake()->company(),
            ];
        }else if($type==="cash_on_delivery"){
            $details = [
                'first_name'=> fake()->firstName(),
                'last_name'=> fake()->lastName(),
                'address'=> fake()->address(),
            ];
        }else if($type==="credit_card"){
            $details = [
                'holder_name'=> fake()->name(),
                'number'=> fake()->creditCardNumber(),
                'ccv'=> fake()->randomNumber(),
                'expire_date'=> fake()->creditCardExpirationDateString(),
            ];
        }

        return [
            'uuid' => fake()->uuid(),
            'type' => $type,
            'details' => $details
        ];
    }
}
