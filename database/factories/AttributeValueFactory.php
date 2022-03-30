<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'attribute_id' => Attribute::all()->random()->id,
            'value' => $this->faker->word(),
            'position' => $this->faker->numberBetween(1, 20),
            'partner_id' => $this->faker->boolean(30) ? NULL : Partner::all()->random()->id,
        ];
    }
}
