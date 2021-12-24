<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorsReviews extends Model
{
  // Table name
  protected $table = 'visitors_reviews';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'review',
    'name',
    'company',
  ];
}
