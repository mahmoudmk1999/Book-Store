<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //هدول مشان اذا في ربط بين جداول هي بينربطوا
        //One To Many
        $category = Category::pluck('id')->toArray();
        $publisher = Publisher::pluck('id')->toArray();

        return [
            'category_id' => fake()->randomElement($category),
            'publisher_id' => fake()->randomElement($publisher),
            'title' => fake()->word,
            'description' => fake()->text,
            'number_of_copies' => fake()->numberBetween(100,200),
            'number_of_pages' => fake()->numberBetween(200,300),
            'price' => fake()->numberBetween(10,50),
            'isbn' => fake()->numberBetween(100000,200000),
            'cover_image' => fake()->imageUrl($width = 640, $height = 480)
        ];
    }
}
