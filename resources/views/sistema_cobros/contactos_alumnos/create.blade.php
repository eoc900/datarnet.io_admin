@extends('sistema_cobros.contactos_alumnos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Crear un nuevo contacto</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('contactos_alumnos.store') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
        <div class="row">
    
    <div class="col-12">
        <label for="buscarAlumno">Buscar alumno</label>
        <x-select2 placeholder="Buscar alumno por nombre" id="buscarAlumno" name="id_alumno" />
    </div>
        
    <x-campo-formulario label="Nombre" id="categoria" name="nombre" type="text" placeholder="Nombre" required="true" parentClass="col-12"/>
    <x-campo-formulario label="Apellido Paterno" id="apellido_paterno" name="apellido_paterno" type="text" placeholder="Apellido Paterno" required="true" parentClass="col-12"/>
    <x-campo-formulario label="Apellido Materno" id="apellido_materno" name="apellido_materno" type="text" placeholder="Apellido Materno" required="true" parentClass="col-12"/>

    <div class="col-12 pt-3 pb-5">
        <x-dropdown-formulario label="Asignar tipo de contacto" :options="$tipos_contactos" value-key="id" option-key="tipo_contacto" simpleArray="false" name="tipo_contacto"/>
    </div>

     {{-- Sección de múltiples inputs para correos del contacto --}}
    <hr>
    <h5 >Define los correos electrónicos del contacto</h5>
    <div class="contenedor_inputs ps-5 pb-5">
        <x-campo-formulario label="Correo" name="correo[]" type="text" placeholder="Nombre" required="true" parentClass="col-12"/>
        <div class="col-12 pt-3">
            <x-dropdown-formulario label="Asignar tipo correo" :options="$tipos_correos" value-key="id" option-key="tipo_correo" simpleArray="false" name="tipo_correo_contacto[]"/>
        </div>
    </div>
    <button type="button" class="agregar_correo btn btn-primary mt-4">+Agregar otro correo</button>

    {{-- Sección de múltiples inputs para teléfonos del contacto--}}
    <hr>
    <h5>Define los teléfonos de este contacto</h5>
    <div class="contenedor_inputs_2 ps-5 pb-5">
        <x-campo-formulario label="Telefono" name="telefono[]" type="text" placeholder="Teléfono" required="true" parentClass="col-12"/>
    </div>
    <button type="button" class="agregar_telefono btn btn-primary mt-4">+Agregar otro teléfono</button>

    {{-- Sección de múltiples inputs para teléfonos del contacto--}}
    <hr>
    <h5>Define las direcciones del contacto.</h5>
    <div class="contenedor_inputs_3 ps-5 pb-5">
            <div class="row">
                    <div class="col-sm-6 pt-4">
                    <label for="calle">Calle:</label>
                    <input type="text" id="calle" name="calle[]"  class="form-control"
                        value="{{ old('calle') }}" required maxlength="32">
                    </div>

                    <div class="col-sm-3 pt-4">
                        <label for="num_exterior">Número Exterior:</label>
                        <input type="text" id="num_exterior" name="num_exterior[]"  class="form-control"
                            value="{{ old('num_exterior') }}" required maxlength="7">
            
                    </div>

                    <div class="col-sm-3 pt-4">
                        <label for="num_interior">Número Interior:</label>
                        <input type="text" id="num_interior" name="num_interior[]" class="form-control"
                            value="{{ old('num_interior') }}" maxlength="7">
                    </div>

                    <div class="col-sm-6 pt-4">
                        <label for="colonia">Colonia:</label>
                        <input type="text" id="colonia" name="colonia[]" class="form-control"
                            value="{{ old('colonia') }}" required >
                    </div>

                    <div class="col-sm-6 pt-4">
                        <label for="codigo_postal">Código Postal:</label>
                        <input type="text" id="codigo_postal" name="codigo_postal[]" class="form-control"
                            value="{{ old('codigo_postal') }}" required >
                    </div>

                    <div class="col-sm-6 pt-4">
                        <label for="codigo_postal">Ciudad:</label>
                        <input type="text" id="ciudad" name="ciudad[]" class="form-control"
                            value="{{ old('ciudad') }}" required>
                    </div>
                    <div class="col-sm-6 pt-4">
                        <label for="codigo_postal">Estado:</label>
                        <input type="text" id="estado" name="estado[]" class="form-control"
                            value="{{ old('estado') }}" required>
                    </div>
                </div>
    </div>
    <button type="button" class="agregar_direccion btn btn-primary mt-4">+Agregar otra dirección</button>

   
       

        <x-boton nombre_boton="Crear contacto" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection