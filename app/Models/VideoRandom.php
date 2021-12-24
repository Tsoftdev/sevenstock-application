<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoRandom extends Model
{
  // Table name
  protected $table = 'video_random';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'video_id',
  ];

  /**
   * Get the video associated with the recommendation.
   */
  public function video()
  {
    return $this->hasOne(Video::class, 'id', 'video_id');
  }
}
