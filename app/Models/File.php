<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name', 'description'
    ];

    public function categories(){
    	return $this->belongsToMany('App\Models\Category');
    }

    public static function boot() {
        parent::boot();
        static::deleted(function($modal) {
            $modal->categories()->sync([]);
        });    
    }
}
