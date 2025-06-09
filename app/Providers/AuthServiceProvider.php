<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
      Gate::define('modify-post', function (User $user, Post $post) {
        return $user->id === $post->author_id;
      });

      Gate::define('modify-comment', function (User $user, Comment $comment) {
        return $user->id === $comment->user_id;
      });
    }
}
