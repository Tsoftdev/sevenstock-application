<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitcustomer extends Model
{
    public $fillable = ['visitId','customerId'];
    public $timestamps = false;
    public function subcustomer() {
        return $this->belongsTo(Customer::class, 'customerId');
    }
}
