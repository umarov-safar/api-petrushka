<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    protected $model = Attribute::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'type' => \Arr::random(array_keys(Attribute::TYPES_OF_ATTRIBUTES)),
            'slug' => $this->faker->slug(),
            'position' => $this->faker->numberBetween(1, 20),
            'partner_id' => $this->faker->boolean(30) ? NULL : Partner::all()->random()->id,
        ];
    }
}
