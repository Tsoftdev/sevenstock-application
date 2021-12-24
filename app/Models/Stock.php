<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    public function getPictureAttribute(){
        return $this->attributes['picture'] ? url($this->attributes['picture']) : asset('images/picture.jpg');
    }

    public function user() {
        return $this->hasOne(Customer::class, 'id', 'userId');
    }

    public function admin() {
        return $this->hasOne(User::class, 'id', 'createdBy');
    }

    public function company() {
        return $this->hasOne(Company::class, 'id', 'companyId');
    }

}
