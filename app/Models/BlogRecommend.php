<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogRecommend extends Model
{
  // Table name
  protected $table = 'blog_recommend';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'blog_id',
  ];

  /**
   * Get the news associated with the recommendation.
   */
  public function blog()
  {
    return $this->hasOne(Blog::class, 'id', 'blog_id');
  }
}
