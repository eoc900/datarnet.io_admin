@extends('sistema_cobros.maestros.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Crear un nuevo maestro</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('maestros.store') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
        <div class="row">
            <div class="col-12">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ejemplo: Ulises" value ="{{ old('nombre') }}" required>
            </div>
            <x-campo-formulario label="Apellido Paterno" id="apellido_paterno" name="apellido_paterno" type="text" placeholder="Apellido Paterno" required="true"
            parentClass="col-12"/>
            <x-campo-formulario label="Apellido Materno" id="apellido_materno" name="apellido_materno" type="text" placeholder="Apellido Materno" required="true"
            parentClass="col-12"/>
            <div class="col-12 pb-5 pt-3">
                <label for="matricula">Matrícula</label>
                <input type="text" class="form-control" id="matricula" name="matricula" placeholder="2390" value ="{{ old('matricula') }}" required>
            </div>
            <div class="col-12 pb-5">
                <label for="nombre">Enlazar a escuela:</label>
                <select name="id_escuela" class="form-control">
                    @foreach ($escuelas as $escuela)
                        <option value="{{ $escuela->id }}">{{ $escuela->nombre }}</option>
                    @endforeach
                </select>
            </div>


            {{-- Correos del contacto múltiples inputs --}}
            <hr>
            <h5>Enlazar correos del maestro.</h5>
            <div class="contenedor_inputs ps-5 pb-5">
                    <label class="mt-4">Correo del maestro</label>
                    <input type="text" name='correo[]' class="form-control">
                    <label class="mt-4">Seleccionar la categoría de correo</label>
                    <select name="tipo_correo[]" class="form-control">
                    @foreach ($tipos_correos as $tipo_correo)
                        <option value="{{ $tipo_correo->id }}">{{ $tipo_correo->tipo_correo }}</option>
                    @endforeach
                    </select>
            </div>
            <button type="button" class="agregar_correo btn btn-primary mt-4 mb-5">+Agregar otro correo</button>

            {{-- Correos del contacto múltiples inputs --}}
            <hr>
            <h5>Enlazar teléfonos del maestro</h5>
            <div class="contenedor_inputs_3 ps-5 pb-5">
                 <label class="mt-4">Telefono del maestro</label>
                <input type="text" name='telefono[]' class="form-control">
            </div>
            <button type="button" class="agregar_telefono btn btn-primary mt-4 mb-5">+Agregar otro teléfono</button>

                {{-- Direcciones del alumno múltiples inputs --}}
            <hr>
            <h5>Enlazar direcciones del maestro</h5>
            <div class="contenedor_inputs_2 ps-5 pb-5">
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

            <div class="col-6 pt-3">
             @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp

            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" />

            </div>

  
        </div>


   
       

        <x-boton nombre_boton="Crear contacto" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection