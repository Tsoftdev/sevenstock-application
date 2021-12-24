<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultingEVS extends Model
{
  // Table name
  protected $table = 'consulting_evs';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'consulting_id',
    'title',
    'date'
  ];
}
