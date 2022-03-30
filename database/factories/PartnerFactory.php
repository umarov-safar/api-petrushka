<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnerFactory extends Factory
{

    protected $model = Partner::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'info' => [
                'address' => $this->faker->address(),
                'email' => $this->faker->email(),
            ],
            'admin_user_id' => User::all()->random()->id,
            'phone' => $this->faker->numerify('###########'),
        ];
    }
}
