<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnerUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'partner_id' => Partner::all()->random()->id,
            'setting_info' => [
            ],
            'phone' => $this->faker->numerify('###########'),
            'status' => $this->faker->boolean(),
            'is_admin' => $this->faker->boolean(10),
        ];
    }
}
