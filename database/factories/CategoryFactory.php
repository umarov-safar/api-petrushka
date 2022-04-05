<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'type' => \Arr::random(Category::TYPES),
            'slug' => $this->faker->slug(),
            'position' => $this->faker->numberBetween(1, 30),
            'active' => $this->faker->boolean(60),
            'partner_id' => Partner::all()->random()->id,
            'icon_url' => $this->faker->imageUrl(),
            'alt_icon' => $this->faker->sentence(),
            'canonical_url' => $this->faker->url(),
            'depth' => $this->faker->numberBetween(1, 3),
            'is_alcohol' => $this->faker->boolean(20)
        ];
    }
}
