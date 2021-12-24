<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultingQA extends Model
{
  // Table name
  protected $table = 'consulting_qa';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'consulting_id',
    'question',
    'answer',
  ];
}
