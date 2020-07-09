<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class author extends Model
{
    public function magazines(){
        return $this->belongsToMany('App\Magazine');
    }
}
