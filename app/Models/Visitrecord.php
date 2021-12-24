<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitrecord extends Model
{
    public function customer() {
        return $this->hasMany(Visitcustomer::class, 'visitId', 'id');
    }
}
