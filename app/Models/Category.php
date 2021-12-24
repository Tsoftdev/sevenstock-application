<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function titles(){
        return $this->belongsToMany('App\Models\File');
    }
}
