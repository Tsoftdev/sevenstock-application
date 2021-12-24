<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquery extends Model
{
    public function company() {
        return $this->belongsTo(Company::class, 'companyId');
    }
}
