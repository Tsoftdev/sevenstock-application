<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoRecommend extends Model
{
  // Table name
  protected $table = 'video_recommend';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'video_id',
    'box_num',
  ];

  /**
   * Get the video associated with the recommendation.
   */
  public function video()
  {
    return $this->hasOne(Video::class, 'id', 'video_id');
  }
}
