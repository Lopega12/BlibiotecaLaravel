<?php

namespace App\Http\Controllers;

use App\Book;
use App\Prestamo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrestamosController extends Controller
{
    public function makePrestamo(Request $r){

        $res = ['error'=>404,'message'=>'Libro o usuario no registrado'];
        if(isset($r->user) && !empty($r->user) && isset($r->libro) && !empty($r->libro)){
            $libroBDD = Book::find($r->user);
            $userBDD = User::find($r->user);

            if(!empty($libro) && !empty($user)){
                $prestamo = new Prestamo();
                $prestamo->id_book = $r->libro;
                $prestamo->id_user = $r->user;
                $prestamo->date_prestamo = date('Y-m-d H:i:s');
                try{
                    $prestamo->save();
                    $res = ['error'=>200,'message'=>'Prestamo Realizado Correcto'];
                }catch(Exception $e){
                    $res = ['error'=>500,'message'=>$e->getMessage()];
                }
            }else{
                $res = ['error'=>404,'message'=>'Recurso no encontrado'];
            }

        }else{
            $res = ['error'=>400,'message'=>'El id del libro es necesaro o es necesario un usuario registrado'];
        }
        return response()->json($res);
    }

    public function devolPrestamo(Request $r){
        $res = ['error'=>404,'message'=>'registro del prestamo no encontrado'];
        if(isset($r->id_prestamo) && !empty($r->id_prestamo)){
            $prestamo = Prestamo::find($r->id_prestamo);
            if(is_null($prestamo->date_devol)){
                try{
                    $prestamo->date_devol = date('Y-m-d H:i:s');
                    $prestamo->save();
                    $res = ['error'=>200,'message'=>'Libro devuelto correctamente'];
                }catch(Exception $e){
                    $res = ['error'=>400,'message'=>$e->getMessage()];
                }
            }else{
                $res = ['error'=>300,'message'=> 'El libro ya ha sido devuelto'];
            }
        }
        return response()->json($res);
    }
    public function allPrestamos($user){
        $prestamos = DB::table('prestamos')->where('id_user',$user)->whereNull('date_devol')->get();
        return response()->json($prestamos);
    }
    public function allDevoluciones($user){
        $prestamos = DB::table('prestamos')->where('id_user',$user)->whereNotNull('date_devol')->get(['id','id_libro','']);
        return response()->json($prestamos);
    }
}
