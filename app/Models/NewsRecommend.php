<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsRecommend extends Model
{
  // Table name
  protected $table = 'news_recommend';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'news_id',
    'box_num',
  ];

  /**
   * Get the news associated with the recommendation.
   */
  public function news()
  {
    return $this->hasOne(News::class, 'id', 'news_id');
  }
}
