<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentHome extends Model
{
  // Table name
  protected $table = 'content_home';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'we_are_here',
    'address',
    'office_number',
    'fax_number',
    'email',
    'map_link',
    'pdf1',
    'pdf2',
  ];
}
