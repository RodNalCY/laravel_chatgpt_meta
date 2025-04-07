<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence,
            'image' => $this->faker->imageUrl(),
            'video' => $this->faker->url(),
            'location' => $this->faker->city,
            'stock' => $this->faker->numberBetween(0, 100),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'discount_price' => $this->faker->randomFloat(2, 5, 400),
            'currency' => 'USD',
            'category' => $this->faker->word,
            'sku' => strtoupper($this->faker->bothify('SKU-####')),
            'url' => $this->faker->url(),
            'active' => $this->faker->randomElement(['yes', 'no']),
        ];
    }
}
