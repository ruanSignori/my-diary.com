<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;

class HomeController extends Controller
{
  public static function index()
  {
    $posts = Post::findLastFiftyPosts();
    return Inertia::render('Home', [
      'posts' => $posts,
    ]);
  }
}
