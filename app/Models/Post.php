<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasDayWeek;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use DateTimeInterface;

class Post extends Model
{
  use HasFactory;
  use HasDayWeek;

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

  protected function serializeDate(DateTimeInterface $date): string
  {
      Carbon::setLocale('pt');
      return Carbon::instance($date)->translatedFormat('d \d\e M \d\e Y');
  }

  public static function findByOwnerAndSlug(string $userName, string $slug): Post
  {
    $data = self::select(
        'posts.id',
        'users.name as author',
        'posts.title',
        'posts.slug',
        'posts.content',
        DB::raw("EXTRACT(DOW FROM posts.created_at) as day_week_created"),
        'posts.created_at',
        'posts.updated_at'
      )
      ->join('users', 'posts.author_id', '=', 'users.id')
      ->where('users.name', $userName)
      ->where('posts.slug', $slug)
      ->first();

    $data->day_week_created = self::getDayWeek($data->day_week_created);
    return $data;
  }
}
