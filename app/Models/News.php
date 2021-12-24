<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
  // Table name
  protected $table = 'news';

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'images' => 'array',
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'title',
    'description',
    'images',
    'date',
    'tag_id',
  ];


  /**
   * Get the tag associated with the news.
   */
  public function tag()
  {
    return $this->hasOne(NewsTags::class, 'id', 'tag_id');
  }
}
