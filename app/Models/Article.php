<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function getImageAttribute(){
        return $this->attributes['image'] ? url($this->attributes['image']) : '';
    }
    
    public function company(){
        return $this->hasOne('App\Models\Company','id','company_id');
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag');
    }
}
