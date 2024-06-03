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
        $tags = [];
        for($i = 0; $i < $this->faker->randomNumber(); $i++){
            $tags[] = $this->faker->word;
        }
        return [
            'title' => $this->faker->title,
            'content' => $this->faker->sentence(16),
            'tags' => $tags,

        ];
    }
}
