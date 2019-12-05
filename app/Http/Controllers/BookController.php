<?php

namespace App\Http\Controllers;

use App\Book;
use DemeterChain\B;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function showAll(){
        $library = Book::all();
        return response()->json($library);
    }
    public function showByGenero($genero){
        $response = Array('codigo_error' =>404, 'message'=>'Libro/s no encontrados con genero'.$genero);
        $library = Book::all()->where('genero',$genero);
        if(!empty($library)){
            $response = $library;
        }
        return response()->json($response);
    }
    public function showByAutor($autor){
        $response = Array('codigo_error' =>404, 'message'=>'Libros no encontrados con autor'.$autor);
        $library = Book::all()->where('autor',$autor);
        if(!empty($library)){
            $response = $library;
        }
        return response()->json($response);
    }
    public function createBook(Request $r){
        $response = array('codigo_error'=>400,'message'=>'Error al crear el libro');
        $book = new Book();
        if(!empty($r)){
            try{
                $book->titulo = $r->titulo;
                $book->sinposis = $r->sinposis;
                $book->genero = $r->genero;
                if(isset($r->autor) && !empty($r->autor)){
                    $book->autor = $r->autor;
                }else{
                    $book->autor = 'Desconocido';
                }
                $book->save();
                $response = array('codigo_error'=>200,'message'=>'Success');
            }catch (\Exception $ex){
                $response = array('codigo_error'=>500,'message'=>$ex->getMessage());
            }

        }else{
            $response = array('codigo_error'=>400,'message'=>'Todos los campos son obligatorios');
        }
        return response()->json($response);
    }

    public function editBook(Request $r,$id){
        $resp = array('codigo_error'=>400,'message'=>'libro no encontrado');
        $book = Book::find($id);
        $correcto = true;
        if(!empty($book)){
            $errores= "";
            if(isset($r->titulo)){
                if(!empty($r->titulo)){
                    $book->titulo = $r->titulo;
                }else{
                    $errores.= "Titulo es obligatorio";
                    $correcto = false;
                }
            }
            if(isset($r->sinopsis)){
                $book->sinopsis = $r->sinopsis;
            }
            if(isset($r->genero)){
                $book->genero = $r->genero;
            }
            if(isset($r->autor)){
                if(!empty($r->autor)){
                    $book->autor = $r->autor;
                }else{
                    $book->autor = 'Desconocido';
                }
            }

           if($correcto){
               try{
                   $book->save();
                   $resp = array('codigo_error'=>200,'message'=>'sucess');
               }catch (\Exception $ex){
                   $resp = array('codigo_error'=>500,'message'=>$ex->getMessage());
               }
           }else{
               $resp = array('codigo_error'=>400,'message'=>$errores);
           }
            return response()->json($resp);
        }
    }
    public function dropBook($id){
        $resp = array('codigo_error'=>400,'message'=>'libro no encontrado');
        $book = Book::find($id);
        if(!empty($book)){
            try{
                $book->delete();
                $resp = array('codigo_error'=>200,'message'=>'Book drop success');
            }catch(\Exception $ex){
                $resp =  $resp = array('codigo_error'=>400,'message'=>$ex->getMessage());
            }
        }
        return response()->json($resp);
    }



}
