<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerStatus extends Model
{
    protected $fillable = [
        'statusName','created_at', 'updated_at'
    ];
}
