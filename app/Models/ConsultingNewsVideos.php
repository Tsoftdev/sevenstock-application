<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultingNewsVideos extends Model
{
  // Table name
  protected $table = 'consulting_news_videos';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'consulting_id',
    'nv_id',
    'type',
  ];


  /**
   * Get the associated news.
   */
  public function news()
  {
    return $this->hasOne(News::class, 'id', 'nv_id');
  }

  /**
   * Get the associated video.
   */
  public function video()
  {
    return $this->hasOne(Video::class, 'id', 'nv_id');
  }
}
