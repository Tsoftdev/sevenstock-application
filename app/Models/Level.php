<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'levelName', 'createdBy', 'isApproved','created_at', 'updated_at', 'isActive', 'isDelete'
    ];
}
