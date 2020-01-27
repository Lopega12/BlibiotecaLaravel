@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            @if(isset($data))
                <div class="alert alert-primary" role="alert">
                    {{$data}}
                </div>
                @endif
            <div class="col-12">
                <form role="form" action="{{ action('BookController@save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Titulo</label>
                        <input type="text" class="form-control" id="name" name="name"/>
                        <label for="autor">Autor</label>
                        <input type="text" class="form-control" id="autor" name="autor" />
                        <label for="genero">Genero</label>
                        <input type="text" class="form-control" id="genero" name="genero" />
                        <label for="sinopsis">Sinopsis</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="sinop" ></textarea>

                        <label for="photo">Titulo de la portada</label>
                        <input type="file" id="photo" name="photo" accept="image/x-png,image/gif,image/jpeg"/>

                        <button type="submit" class="btn btn-primary" name="enviar">Enviar</button>
                        <button type="reset" class="btn btn-default">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
