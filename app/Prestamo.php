<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    public function libros(){
        return $this->belongsToMany('App\Book','libros');
    }
}
