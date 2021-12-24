<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultingAttachment extends Model
{
  // Table name
  protected $table = 'consulting_attachment';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'consulting_id',
    'name',
    'attachment',
  ];
}
