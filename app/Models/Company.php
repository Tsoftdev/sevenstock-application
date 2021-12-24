<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'companyName', 'createdBy', 'isApproved','created_at', 'updated_at', 'isActive', 'isDelete'
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'createdBy');
    }

    public function stocks() {
        return $this->hasMany(Stock::class, 'companyId', 'id');
    }

    public function inquery() {
        return $this->hasMany(Inquery::class, 'companyId', 'id');
    }

    public function stockholders() {
        return $this->hasManyThrough(Customer::class, Stock::class, 'companyId', 'id');
    }

    public function getImageAttribute(){
        return $this->attributes['companylogo'] ? url($this->attributes['companylogo']) : '';
    }
}
