<?php

namespace App\Http\Controllers;

use App\Book;
use DemeterChain\B;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function showAll(){
        $library = Book::all();
        return response()->json($library);
    }
    public function showByGenero($genero){
        $response = Array('codigo_error' =>404, 'message'=>'Libro/s no encontrados con genero'.$genero);
        $library = Book::all()->where('genero', ucfirst (strtolower ($genero)));
        if(!empty($library)){
            $response = $library;
        }
        return response()->json($response);
    }
    public function showByAutor($autor){
        $response = Array('codigo_error' =>404, 'message'=>'Libros no encontrados con autor'.$autor);
        $library = DB::table('books')->where('autor','like ','%'.$autor.'%')->orWhere('autor','like','%'.$autor)->orWhere('autor','like',$autor.'%')->get();
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
                $book->titulo = ucfirst (strtolower ($r->titulo));
                $book->sinposis = ucfirst (strtolower ($r->sinposis));
                $book->genero = ucfirst(strtolower ($r->genero));
                if(isset($r->autor) && !empty($r->autor)){
                    $book->autor = ucfirst(strtolower ($r->autor));
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
                if(!is_null($r->titulo)){
                    $book->titulo = ucfirst(strtolower ($r->titulo));
                }else{
                    $correcto = false;
                    $resp['message'].='Book,should contain Titulo';
                }
            }
            if(isset($r->sinopsis)){
                if(!is_null($r->sinopsis)){
                    $book->sinopsis = ucfirst(strtolower ($r->sinopsis));
                }else{
                    $correcto = false;
                    $resp['message'].='Book,shold be contain sinopsis';
                }
            }
            if(isset($r->genero)){
                if(!is_null($r->genero)){
                    $book->genero = ucfirst(strtolower ($r->genero));
                }else{
                    $correcto = false;
                     $resp['message'].='Book,should be contain genero';
                }
            }
            if(isset($r->autor)){
                if(!is_null($r->autor)){
                    $book->autor = ucfirst(strtolower ($r->autor));
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
               $resp = array('codigo_error'=>300,'message'=>$resp['message']);
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

    public function index(){
        return view('newBook');
    }
    public function save(){
          $dirname = substr(dirname(__FILE__),0,strripos(dirname(__FILE__),'storage'));
        if(isset($_POST['enviar'])){
            $title = (isset($_POST['name'])) ? $_POST['name'] : "";
            $autor = (isset($_POST['autor'])) ? $_POST['autor'] : 'Desconocido';
            $genero = (isset($_POST['genero'])) ? $_POST['genero'] : '';
            $sinop = (isset($_POST['sinop'])) ? $_POST['sinop'] : "";
            $portada = (isset($_FILES['photo']) && !empty($_FILES['photo'])) ? $_FILES['photo'] : "";
            if($portada['error'] == 0 && ($portada['type'] =='image/x-png' ||$portada['type'] == 'image/gif' ||$portada['type'] =='image/jpeg')){
                if(move_uploaded_file($portada['tmp_name'],$dirname.$portada['name'])){

                    $book = new Book();
                    $book->titulo =  $title;
                    $book->sinposis = $sinop;
                    $book->autor = $autor;
                    $book->genero = $genero;
                    $book->portada = $dirname.$portada['name'];
                    $book->save();
                    $data = "libro subido correctamente";
                }

            }

            // var_dump($portada);
            //print("$title, $autor, $genero, $sinop");

        }
        return view('newBook', ['data' => $data
        ]);
    }



}
