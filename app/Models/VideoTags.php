<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoTags extends Model
{
  // Table name
  protected $table = 'video_tags';

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
   * Get the video associated with the tag.
   */
  public function video()
  {
    return $this->hasMany(Video::class, 'tag_id', 'id');
  }
}
