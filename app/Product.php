<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand');
    }

    public function sizes()
    {
        return $this->belongsToMany('App\Size')->withTimestamps();
    }

    public function colors()
    {
        return $this->belongsToMany('App\Color')->withTimestamps();
    }

}
