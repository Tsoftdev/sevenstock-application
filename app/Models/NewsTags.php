<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsTags extends Model
{
  // Table name
  protected $table = 'news_tags';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'keyword',
    'color'
  ];


  /**
   * Get the news associated with the tag.
   */
  public function news()
  {
    return $this->hasMany(News::class, 'tag_id', 'id');
  }
}
