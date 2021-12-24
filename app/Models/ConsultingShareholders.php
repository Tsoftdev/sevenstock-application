<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultingShareholders extends Model
{
  // Table name
  protected $table = 'consulting_shareholders';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'consulting_id',
    'ceo',
    'percent'
  ];
}
