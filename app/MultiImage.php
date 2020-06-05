<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MultiImage extends Model
{
    public function products()
    {
        return $this->belongsToMany('App\Product')->withTimestamps();
    }
}
