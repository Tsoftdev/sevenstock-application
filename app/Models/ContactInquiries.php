<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiries extends Model
{
  // Table name
  protected $table = 'contact_inquiries';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name',
    'company_name',
    'phone_number',
    'inquiry',
    'inquiry_type',
    'attachment',
  ];
}
