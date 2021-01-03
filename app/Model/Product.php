<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{



    public function reviews(){
        $this->hasMany(Review::class);
    }
}
