<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
  // Table name
  protected $table = 'blog';

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
   * Get the tag associated with the blog.
   */
  public function tag()
  {
    return $this->hasOne(BlogTags::class, 'id', 'tag_id');
  }
}
