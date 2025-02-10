<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'slug',
    'content',
    'author_id'
  ];

  public function user()
  {
      return $this->belongsTo(User::class, 'author_id');
  }

  public static function findByOwnerAndSlug(string $userName, string $slug): Post
  {
    $data = self::select('posts.id', 'users.name as author', 'posts.title', 'posts.slug', 'posts.content', 'posts.created_at')
                ->join('users', 'posts.author_id', '=', 'users.id')
                ->where('users.name', $userName)
                ->where('posts.slug', $slug)
                ->first();
    return $data;
  }

}
