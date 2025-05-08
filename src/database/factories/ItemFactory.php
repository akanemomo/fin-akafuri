<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => 1, // 仮で1（あとでSeederで調整OK）
            'name' => $this->faker->words(2, true),
            'brand' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'category_id' => 1, // 仮で1（あとでSeederで調整OK）
            'condition' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->numberBetween(1000, 10000),
            'image_path' => 'fruits-img/sample.png', // 仮の画像パス
        ];
    }
}
