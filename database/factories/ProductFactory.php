<?php

namespace Database\Factories;

use Faker\Generator as Faker;

use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\Factory;



/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'sku' => $this->faker->unique()->numerify('SKU-######'),
            'category_id' => $this->faker->numberBetween(1, 10),
            'stock_quantity' => $this->faker->numberBetween(1, 100),
            'image_url' =>"https://placehold.co/600x400",
            'status' => $this->faker->randomElement(['available', 'unavailable']),
            'discount' => $this->faker->randomFloat(2, 0, 0.5),
            'weight' => $this->faker->randomFloat(2, 0.1, 10),
            'dimensions' => $this->faker->randomElement(['10x10x10', '20x20x20', '30x30x30']),
            'tags' => implode(',', $this->faker->words(3)),
            'user_id' => 1, // Assuming user_id 1 exists
        ];
    }
}