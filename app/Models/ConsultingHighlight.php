<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultingHighlight extends Model
{
  // Table name
  protected $table = 'consulting_highlight';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'consulting_id',
    'content',
  ];
}
