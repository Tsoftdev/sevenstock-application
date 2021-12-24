<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stockbroker extends Model
{
    protected $fillable = [
        'brokerName', 'createdBy', 'isApproved','created_at', 'updated_at', 'isActive', 'isDelete'
    ];
}
