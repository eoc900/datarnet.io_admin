@extends('sistema_cobros.layouts.index')
@section("content")

<h5 class="text-center pb-5 pt-5">Escuela: {{ $datos["sistema"]->escuela }} <b>({{ $datos["sistema"]->codigo_escuela }})</b></h5>

<div class="card w-100 rounded-4">
<div class="card-body">
<div class="row">
    <div class="col-12 mt-3">

        <h3><b>Sistema:</b> {{ $datos["sistema"]->nombre; }} [código: {{ $datos["sistema"]->codigo_sistema; }}]:</h3>
        <p><b>Alumnos registrados:</b> {{ $datos["cantidad_alumnos"] }}</p>
    </div>
</div>
</div>
</div>



@endsection