<?php

namespace App\Http\Controllers;

use App\prestamo;
use Illuminate\Http\Request;

class PrestamosController extends Controller
{
    public function makePrestamo(Request $r){
        if(isset($r->user) && !empty($r->user) && isset($r->libro) && !empty($r->libro)){
            $prestamo = new Prestamo();
            $prestamo->id_book = $r->libro;
            $prestamo->id_user = $r->id_user;
            $prestamo->date_prestamo = date('Y-m-d H:i:s');
        }else{
            //me quedo por aqui//
        }
    }
}
