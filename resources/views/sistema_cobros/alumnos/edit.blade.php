@extends('sistema_cobros.alumnos.layouts.edit')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Editar alumno</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('alumnos.update',$alumno->id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <x-lista-mensajes/>
        <div class="row">
            <div class="col-12">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ejemplo: Ulises" value ="{{ $alumno->nombre }}" required>
            </div>
            <x-campo-formulario label="Apellido Paterno" id="apellido_paterno" name="apellido_paterno" type="text" :value="$alumno->apellido_paterno" placeholder="Apellido Paterno" required="true"
            parentClass="col-12"/>
            <x-campo-formulario label="Apellido Materno" id="apellido_materno" name="apellido_materno" type="text" :value="$alumno->apellido_materno" placeholder="Apellido Materno" required="true"
            parentClass="col-12"/>
             <x-campo-formulario label="Matrícula" id="matricula" name="matricula" type="text" :value="$alumno->matricula" placeholder="Matrícula del alumno"
            parentClass="col-12"/>
            <div class="col-12 pt-4">
            <label for="sistema">Sistema Académico</label>
            <select name="sistema_academico" id="sistema" class="form-control mt-3">
               @foreach ($sistemas_academicos as $sistema)
                   <option value="{{ $sistema->id }}" {{ ($alumno->id_sistema_academico==$sistema->id)?"selected":"" }}>{{ $sistema->nombre }}</option>
               @endforeach
            </select>
            </div>


            <div class="col-6  pb-5">
                @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
                @endphp
                <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" :selected="$alumno->activo"/>  
            </div>
            <x-boton nombreBoton="Editar alumno" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection