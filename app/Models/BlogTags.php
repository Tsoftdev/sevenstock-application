<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogTags extends Model
{
  // Table name
  protected $table = 'blog_tags';

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
   * Get the blog associated with the tag.
   */
  public function blog()
  {
    return $this->hasMany(Blog::class, 'tag_id', 'id');
  }
}
