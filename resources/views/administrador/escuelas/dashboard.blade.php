@extends('sistema_cobros.layouts.index')
@section("content")

<h5 class="text-center pb-5 pt-5">Escuela: {{ $datos["escuela"]["nombre"] }}</h5>

<div class="card w-100 rounded-4">
<div class="card-body">
<div class="row">
    <div class="col-6">
        <p>Sistemas Académicos ({{ $datos["conteo_sistemas"] }}):</p>
  
        <ul>
            @foreach ($datos["sistemas"] as $sistema)
                <li>{{ $sistema->sistema }} <b>| {{ $sistema->codigo_sistema }}:{{ ($sistema->activo)?"Activo":"Inactivo" }} </b></li>
            @endforeach

        </ul>
    </div>
</div>
</div>
</div>



@endsection