<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'uuid' => fake()->uuid(),
            'is_admin' => fake()->boolean(50),
            'avatar' => "",
            'address_title' => fake()->streetAddress(),
            'address_line_1' => fake()->streetAddress(),
            'address_line_2' => fake()->streetAddress(),
            'address_line_3' => fake()->streetAddress(),
            'address_line_4_city' => fake()->city(),
            'address_line_5_state' => "",
            'address_line_6_zip' => fake()->numberBetween(100, 1000),
            'address_line_7_country' => fake()->country(),
            'phone_number_country_code' => '',
            'phone_number' => fake()->e164PhoneNumber(),
            'is_marketing' => fake()->boolean(50),
            'last_login_at' => new \DateTime(),
            'created_at' => fake()->dateTimeBetween("-10 days","now"),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
