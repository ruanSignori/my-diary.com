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

  public static function findByOwnerAndSlug($ownerId, string $slug): Post
  {
      return self::where('author_id', $ownerId)
                 ->where('slug', $slug)
                 ->first();
  }

}
