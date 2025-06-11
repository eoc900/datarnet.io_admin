@extends('sistema_cobros.horarios_maestros.layouts.busqueda_maestro')
@section("content")
@include('components.sistema_cobros.response')

<div class="card">
    <div class="card-body">
          <div class="mb-5">
            <h5>Por favor selecciona algún maestro</h5>
            <hr>
            <label for="buscarMaestro">Selecciona a un maestro</label>
            <x-select2 placeholder="Buscar usuario o rol" id="buscarMaestro" name="maestro" />
            </div>
    </div>
</div>

@endsection