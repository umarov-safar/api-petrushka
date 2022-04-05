<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'inn' => $this->faker->numerify('############'),
            'phone' => $this->faker->phoneNumber,
            'info' => [
              'name' => $this->faker->company,
              'short_name' => $this->faker->companySuffix,
              'address' => $this->faker->address,
              'email' => $this->faker->email
            ],
            'admin_user_id' => User::all()->random()->id,
            'is_block' => $this->faker->boolean(3),
        ];
    }
}
