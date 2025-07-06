@extends('sistema_cobros.tablas_modulos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')  
  
  
<div class="card">
<div class="card-header pt-3">
    <h5>Nueva tabla</h5>
</div>
<div class="card-body p-5">
    @if (isset($success))
        <div class="col-12">
            <p>Información del Archivo:<p>
            <ul>
                <li><strong>Nombre:</strong> {{ $archivo_info["nombre"] }}</li>
                <li><strong>Tipo:</strong> {{ $archivo_info["tipo"] }}</li>
                <li><strong>Tamaño:</strong> {{ $archivo_info["tamano"] }} bytes</li>
            </ul>
        </div>
        <div class="columnas">
            <h5>Columnas de tu tabla EXCEL:</h5>
            <div class="contenido_config_cols">
                <form class="row" method="post" action="{{ route('insertar.columnas') }}" enctype="multipart/form-data">
                @csrf
                <x-lista-mensajes/>
                <input type="hidden" value="{{ $id_tabla }}" name="id_tabla">

                    {{-- Configuración de columnas --}}
                    <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Columna</th>
                            <th class="text-center">Tipo Dato</th>
                            <th class="text-center"># Caracteres</th>
                            <th class="text-center">Llave primaria</th>
                            <th class="text-center">Unique</th>
                            <th class="text-center">Null</th>
                            <th class="text-center">Foranea</th>
                            <th class="text-center">Tabla foranea</th>
                            <th class="text-center">Columna foranea</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($archivo_info["columnas"] as $index=>$columna)
                            @include('components.form_creator.tipos_datos_dropdown',[
                                "name"=>$columna,
                                "index"=>$index,
                                "tablas"=>$tablas,
                                "tipos_datos"=>$tipos_datos,
                                "es_carga_excel"=>true
                            ])
                        @endforeach
                    </tbody>
                    </table>
                <x-boton nombre_boton="Guardar columnas" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
                </form>
            </div>


           
            <hr>
         
            
           

           
        </div>
    @endif
</div>


@endsection