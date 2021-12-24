<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customergroup extends Model
{
    protected $fillable = [
        'groupName', 'createdBy', 'isApproved','created_at', 'updated_at', 'isActive', 'isDelete'
    ];
}
