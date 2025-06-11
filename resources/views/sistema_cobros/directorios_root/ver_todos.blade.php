@extends('sistema_cobros.directorios_root.layouts.index')
@section("content")

    <div class="card">
        <div class="card-body">
            <div class="row">
                 @foreach ($todos as $directorio)
                <div class="col-4">
                    <div class="card" style="width: 18rem;">
                    <img src="{{ asset("dashboard_resources/assets/images/card_directory.jpg"); }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{ $directorio->nombre_directorio }}</h5>
                        <p class="card-text">{{ $directorio->usuario }}</p>
                        <a href="{{ route("ver_contenido",['id_directorio' => $directorio->id,'ruta'=>$directorio->nombre_directorio]); }}" class="btn btn-primary float-end">Abrir</a>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>

         
         
        </div>
    </div>


@endsection


