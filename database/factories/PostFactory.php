<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
      'title' => 'Post de exemplo, by: ' . fake()->name(),
      'slug' => Str::slug(fake()->name()),
      'content' => 'Hello World',
      'author_id' => User::first()
    ];
  }

  public function configure()
  {
    return $this->afterCreating(function (Post $post) {
      $category = Category::inRandomOrder()->first();

      // Associa o post à categoria
      $post->categories()->attach($category->id);
    });
  }
}
