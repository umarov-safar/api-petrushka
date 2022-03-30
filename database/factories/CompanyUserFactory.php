<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyUserFactory extends Factory
{

    /**
     * Company users model
     * @var string
     */
    protected $model = CompanyUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'company_id' => Company::all()->random()->id,
            'setting_info' => [
                'max_money' => $this->faker->numerify('####'),
                'min_money' => $this->faker->numerify('###'),
            ],
            'phone' => $this->faker->numerify('###########'),
            'status' => $this->faker->boolean(),
            'is_admin' => $this->faker->boolean(10),
        ];
    }
}
