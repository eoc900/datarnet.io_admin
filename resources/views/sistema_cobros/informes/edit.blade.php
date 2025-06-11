@extends('sistema_cobros.informes.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
    <div class="card-header pt-3">
        <h3>Crear un nuevo informe</h3>
    </div>
    <form method="post" action="{{ route('informes.update',$id_informe) }}" enctype="multipart/form-data">
	@csrf

    <div class="card">
        <div class="card-body">
            {{-- Inputs básicos --}}
            <label for="" class="form-label">Nombre del informe</label>
            <input type="text" class="form-control mb-4" value="{{ $nombre??'' }}" name="nombre_informe">
            <label for="" class="form-label">Descripción</label>
            <textarea name="descripcion_informe" class="form-control mb-4" id="" cols="30" rows="5" placeholder="Describe que quieres mostrar">{{ $descripcion??'' }}</textarea>
            <input type="hidden" value="{{ $estructura['clave']??'' }}" name="clave">
            {{-- Inputs básicos --}}

            {{-- Filtros que se pueden activar --}}
            @include('sistema_cobros.informes.configuraciones.listados_filtros_switch',["filtros"=>($estructura["filtros"]??'')])
            <div class="row mt-5">                                 
                    @include('sistema_cobros.informes.configuraciones.date_filter_config',["filtros"=>($estructura["filtros"]??'')])  
                    @include('sistema_cobros.informes.configuraciones.text_filter_config',["filtros"=>($estructura["filtros"]??'')])           
            </div>
            {{-- Filtros que se pueden activar --}}

            {{-- Elementos que pueden agregarse al informe --}}
            @include('sistema_cobros.informes.componentes.dropdown_opciones_elementos')
            {{-- Elementos que pueden agregarse al informe --}}
        </div>
    </div>
    <hr>

    <div class="card-body bg-light">
         <!-- Aquí tu contenido con Bootstrap y gráficas ApexCharts -->
        <div class="col-sm-12 mb-5">
                <h1 class="text-center">Reporte PDF</h1>
        </div>
        <div id="contenido-para-pdf" class="row p-3 align-items-start bg-white">
           
            
            {{-- CARGA DE SECCIONES GUARDADAS EN config_temp.json --}}
            @if(isset($estructura["secciones"]))
                    @foreach ($estructura["secciones"] as $item)
                        @include('sistema_cobros.informes.componentes.render_config',$item)
                    @endforeach
            @endif

           
            {{-- <div class="col-sm-6 mt-5 seccion">
                  <div id="grafica" class="border"></div>
            </div> --}}
          
            
        </div>

        <!-- Botón para generar PDF -->
        <button id="generar-pdf" class="btn btn-primary no-print" type="button">Generar PDF</button>
        <button id="enviar-servidor" class="btn btn-success no-print" type="button">Enviar a Servidor</button>

    </div>
</div>


    {{-- Sidebar --}}
    @include('sistema_cobros.informes.componentes.sidebar')
    {{-- Sidebar --}}
    <div class="card">
            <button type="submit" class="btn btn-grd-primary px-4 text-white">Guardar</button>	
    </div>
         													
</form>


@endsection

@push("funciones_graficas")
    @include('sistema_cobros.informes.componentes.script_area_chart')
    @include('sistema_cobros.informes.componentes.script_bar_chart')
    @include('sistema_cobros.informes.componentes.script_line_chart')
    @include('sistema_cobros.informes.componentes.script_pie_chart')
@endpush