@extends('sistema_cobros.tipos_correos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Editar sistema académico</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('sistemas_academicos.update',$sistema->id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <x-lista-mensajes/>
        <div class="row">
             <div class="col-12">
               @php
                    $modalidades = [
                        ["id" => "Escolarizado", "option" => "Escolarizado"],
                        ["id" => "Semi-Escolarizado", "option" => "Semi-Escolarizado"]
                    ];
                @endphp

                <label for="sistema">Modalidad</label>
                <select name="modalidad" id="modalidad" class="form-control mt-3">
                    @foreach ($modalidades as $modalidad)
                        <option value="{{ $modalidad['id'] }}" {{ ($sistema->modalidad == $modalidad['id']) ? "selected" : "" }}>
                            {{ $modalidad['option'] }}
                        </option>
                    @endforeach
                </select>
            </div>
      
            <x-campo-formulario label="Código Sistema Académico" id="codigo_sistema" name="codigo_sistema" type="text" :value="$sistema->codigo_sistema" placeholder="INGSistemasDigitales" required="true"
                    parentClass="col-12"/>


            <x-campo-formulario label="Nombre Oficial" id="nombre" name="nombre" type="text" :value="$sistema->nombre" placeholder="Ingeniería en Sistemas Digitales" required="true" parentClass="col-12"/>
            
            <div class="col-12 pt-3">
                <x-dropdown-formulario label="Nivel Académico" id="nivel_academico" :options="$niveles" value-key="id" option-key="option" simpleArray="true" name="nivel_academico" activo="activo" :selected="$sistema->nivel_academico"/>
            </div>

            <div class="col-12 pt-3">
                <x-dropdown-formulario label="Escuela" id="codigo_escuela" :options="$escuelas" value-key="id" option-key="codigo_escuela" simpleArray="false" name="id_escuela" activo="activo" :selected="$sistema->id_escuela"/>
            </div>

            <div class="col-6 pt-3">
            @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp

            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" :selected="$sistema->activo"/>

            </div>
           
        </div>
         <x-boton nombre_boton="Editar" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection