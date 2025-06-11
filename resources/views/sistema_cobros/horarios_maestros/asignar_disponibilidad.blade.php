@extends('sistema_cobros.horarios_maestros.layouts.index')
@section("content")


<div class="card">
    <div class="card-body">
        <div class="my-5 ">
            <a href="{{ route("disponibilidad.maestro"); }}" class="btn btn-outline-primary "><span class="font-15">	<i class="lni lni-search"></i>
            </span>Buscar otros</a>
        </div>
        <hr>
            <h5>{{ $info->nombre }} {{ $info->apellido_paterno }}{{ $info->apellido_materno }}</h5>
        <hr>
        <div class="table-responsive">
            <div id='calendar'></div>
        </div>
    </div>
</div>

{{-- Modales --}}
@include('components.sistema_cobros.modales.confimar_horario')
@include('components.sistema_cobros.modales.eliminar_horario')

@endsection