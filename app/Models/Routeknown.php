<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Routeknown extends Model
{
    protected $fillable = [
        'routeName', 'createdBy', 'isApproved','created_at', 'updated_at', 'isActive', 'isDelete'
    ];
}
