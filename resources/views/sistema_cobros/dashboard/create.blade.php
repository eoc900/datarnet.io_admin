@extends('sistema_cobros.dashboard.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
    <div class="card-header pt-3">
        <h5>Crear un nuevo dashboard informativo</h5>
    </div>
    <div class="card-body bg-light">
        <form class="row" method="post" action="{{ route('materias.store') }}" enctype="multipart/form-data">
            @csrf
            <x-lista-mensajes/>

                {{-- Selecciona el layout del siguiente indicador --}}
                <label for="" class="form-label">Seleccionar espacio a usar</label>
                <div class="input-group">
                    @include('components.dashboard.dropdown_seccion_indicador')
                </div>

                {{-- Default aqui --}}
                <div class="contenedor-seleccion mt-5 row">
                    {{-- <div class="indicator-section shadow card p-3 col-md-6"></div> --}}
                      
                   
                </div>
                {{-- Default aqui --}}
            
        </form>
    </div>
</div>
@endsection

@push("funciones_graficas")
    @include('sistema_cobros.dashboard.componentes.script_area_chart')
    @include('sistema_cobros.dashboard.componentes.script_bar_chart')
    @include('sistema_cobros.dashboard.componentes.script_line_chart')
    @include('sistema_cobros.dashboard.componentes.script_pie_chart')
@endpush