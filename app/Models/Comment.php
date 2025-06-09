<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Comment extends Model
{
  protected $fillable = [
    'post_id',
    'user_id',
    'parent_id',
    'content',
    'deleted_at'
  ];

  public function post()
  {
    return $this->belongsTo(Post::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function parent()
  {
    return $this->belongsTo(Comment::class, 'parent_id');
  }

  public function children()
  {
    return $this->hasMany(Comment::class, 'parent_id');
  }
}
