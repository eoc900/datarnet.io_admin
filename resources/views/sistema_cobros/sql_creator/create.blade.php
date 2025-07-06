@extends('sistema_cobros.sql_creator.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Crear consulta</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('sql_creator.store') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>

         @if(session("consulta"))
            <div class="alert alert-warning alert-dismissible fade show">
                {{ print_r(session("consulta")); }}
            </div>
        @endif

        <div class="row">
            <x-campo-formulario label="Nombre del query" id="nombre_query" name="nombre_query" type="text" placeholder="traer_alumnos_inscritos_202501" required="true"  parentClass="col-12"/>
            <div class="col-md-12">
                <label for="descripcion" class="form-label mt-3">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Para qué sirve este reporte, o qué datos quieres obtner."
                rows="2"></textarea>
            </div>

            <div class="col-12 mt-5">

            @if(isset($tablas) && count($tablas)>0)
            <label for="opciones_tabla" class="form-label">Seleccionar una tabla</label><br>
            <div class="input-group mb-3">
                <select name="opciones_tablas" id="opciones_tabla" class="form-control float-start">
                @foreach ($tablas as $tabla)
                    <option value="{{ $tabla }}">{{ $tabla }}</option>
                @endforeach
                </select>
                <button type="button" class="seleccionar_tabla btn btn-primary float-end">Seleccionar +</button>
            </div>
            @endif
            
            </div>

            <div class="contenedor_columnas">
                {{-- Aquí vamos a insertar las tablas seleccionadas --}}
            </div>

            <div class="col-6">
                <div class="seccion_tablas text-center p-2">
                            <p class="text-center seleccionar_tabla_aqui">Selecciona tus tablas <i class="lni lni-library"></i></p>
                </div>
            </div>

            <div class="col-6">
                <div class="seccion_columnas text-center p-2 mb-3">
                            <p class="text-center seleccionar_tabla_aqui">Selecciona tus columnas <i class="lni lni-line-dashed"></i></p>
                </div>
            </div>



             {{-- ------> Para ejecutar funciones agregadas --}}
            <hr>
            <div class="col-12">
                <p class="text-center subtitle"><i class="fadeIn animated bx bx-calculator"></i> Múltiples Funciones para una sóla columna columna</p>
            </div>

            <div class="col-10 mb-3 mx-auto">
                <div class="convertir-columna p-4 rounded">
                       <p class="label-box text-center border-bottom p-1"> <i class="fadeIn animated bx bx-plus"></i> Arrastra la columna aquí </p>
                </div>
            </div>
           
      
            {{-- ------> Para ejecutar funciones agregadas --}}



            {{-- ------> Para hacer los joins --}}
            <hr>
            <div class="col-12">
                <p class="text-center subtitle"><i class="fadeIn animated bx bx-link-alt"></i> Arrastra las columnas seleccionadas a las zonas de JOIN correspondientes</p>
            </div>


            <div class="col-3 mb-3">
                <div class="seccion-dropdowns pt-4">

                </div>
            </div>

            <div class="col-4 mb-3">
                <div class="drop-column-left p-4">
                        {{-- <input type="text" disabled name="join_column_l[]" > --}} 
                </div>
            </div>
            <div class="col-1 text-center mb-3">
                <button type="button" class="btn btn-warning mt-4">=</button>
            </div>
            <div class="col-4 mb-3">
                <div class="drop-column-right p-4">
                        {{-- <input type="text" disabled name="join_column_l[]" > --}} 
                </div>
            </div>
            <hr>
            {{-- ------> Para hacer los joins --}}

            {{-- ------> Para hacer las condiciones --}}
             <div class="col-12 mt-2">
                <p class="text-center subtitle"> <i class="fadeIn animated bx bx-detail"></i> Condiciones WHERE</p>
            </div>
            <div class="col-2">
                <div class="operadores_logicos pt-4">
                    
                </div>
            </div>
            <div class="col-4">
                <div class="columna-where p-4">
                        {{-- <input type="text" disabled name="join_column_l[]" > --}} 
                </div>
            </div>
            <div class="col-2 text-center">
                <div class="operadores-where pt-4 pb-4">

                </div>
            </div>
            <div class="col-4">
                <div class="valores-where p-4">
                        {{-- <input type="text" disabled name="join_column_l[]" > --}} 
                </div>
            </div>
            {{-- ------> Para hacer las condiciones --}}

            {{-- ------> Group by --}}
             <div class="col-12 mt-5">
                <p class="text-center subtitle"> <i class="fadeIn animated bx bx-detail"></i> Agrupar (opcional*)</p>
            </div>
            <div class="col-12">
                <div class="agrupaciones p-4">
                        {{-- <input type="text" disabled name="join_column_l[]" > --}} 
                </div>
            </div>
            {{-- ------> Para hacer las condiciones --}}




           

            
            
            <x-boton nombre_boton="Generar plantilla de reporte" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection