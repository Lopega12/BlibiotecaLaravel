<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/books','BookController@showAll');
Route::get('/books/genero/{slug}','BookController@showByGenero')->name('BookController');
Route::get('/books/autor/{slug}','BookController@showByAutor')->name('BookController');

Route::middleware('auth:api')->post('/books/create','BookController@createBook');
Route::middleware('auth:api')->put('/books/edit/{slug}','BookController@editBook');
Route::middleware('auth:api')->delete('/books/drop/{slug}','BookController@dropBook');

Route::middleware('auth:api')->post('/prestamos/prestar','PrestamosController@makePrestamo');
Route::middleware('auth:api')->put('/prestamos/devolver','PrestamosController@devolPrestamo');
Route::middleware('auth:api')->get('/prestamos/{id}','PrestamosController@allPrestamos');
Route::middleware('auth:api')->get('/prestamos/devol/{id}','PrestamosController@allDevoluciones');





Route::middleware('auth:api')->post('register', 'AuthController@register');


