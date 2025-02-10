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

  public static function findByOwnerAndSlug($ownerId, string $slug): Post
  {
    $data = self::select('posts.*', 'users.name as author')
                ->join('users', 'posts.author_id', '=', 'users.id')
                ->where('author_id', $ownerId)
                ->where('slug', $slug)
                ->first();
    return $data;
  }

}
