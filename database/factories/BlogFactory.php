<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'blog_title' => $this->faker->sentence(10),
            'blog_text' => $this->faker->paragraph(),
            'publication_datetime' => $this->faker->dateTimeBetween('-3 months', 'now'),
            'user_id' => 1,
        ];
    }
}
