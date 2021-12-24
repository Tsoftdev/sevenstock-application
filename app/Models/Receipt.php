<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    public function employee() {
        return $this->hasOne(Employee::class, 'id', 'employeeId');
    }
    public function receiptitem() {
        return $this->hasMany(Receiptitem::class, 'receiptId', 'id');
    }
    public function invoicephoto() {
        return $this->hasMany(Invoicephoto::class, 'receiptId', 'id');
    }
}
