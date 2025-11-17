<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'title'=>fake()->sentence(),
           'prologue'=>fake()->sentence(),
           'body'=>fake()->text(),
           'count'=>Rand(1,200),
           'link'=>fake()->url()
        ];
    }
}
