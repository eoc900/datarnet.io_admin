@extends('sistema_cobros.inscripciones.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Generar inscripción(es)</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('reformular_titulos') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
        <div class="row">
    
            <div class="col-12">
                <label for="buscarAlumno">Buscar alumno</label>
                <x-select2 placeholder="Buscar alumno por nombre" id="buscarAlumno" name="id_alumno" />
            </div>
            <div class="col-12">
                <x-dropdown-formulario label="Modalidad" id="activo" :options="$modalidades" value-key="id" option-key="option" simpleArray="true" name="modalidad" />
            </div>

            <div class="contenedor_inputs ps-5 pb-5">
                <x-dropdown-anio label="Selecciona el año" id="anio" name="anio[]" />
                <x-dropdown-cuatrimestre label="Selecciona el cuatrimestre" id="cuatri" name="cuatri[]" />
                <x-dropdown-formulario label="Tipo de inscripción" id="activo" :options="$tipos_inscripcion" value-key="id" option-key="option" simpleArray="true" name="tipo_inscripcion[]" />
            </div>
            <button type="button" class="agregar_inscripcion btn btn-primary mt-4">+ Agregar periodo</button>
            <x-boton nombre_boton="Crear contacto" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>
@endsection