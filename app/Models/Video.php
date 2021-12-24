<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
  // Table name
  protected $table = 'video';

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
    'video_link',
    'tag_id',
  ];


  /**
   * Get the tag associated with the video.
   */
  public function tag()
  {
    return $this->hasOne(VideoTags::class, 'id', 'tag_id');
  }
}
