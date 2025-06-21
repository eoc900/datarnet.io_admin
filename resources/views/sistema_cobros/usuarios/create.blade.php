@extends('general.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
        <div class="card-header pt-3">
                <h5>Crear un nuevo usuario</h5>
        </div>
        <div class="card-body">
     
       

  <form action="{{ "users.store" }}" method="POST" enctype="multipart/form-data"></form>
    <div class="row">

        <x-campo-formulario label="Nombre" id="nombre" name="name" type="text" placeholder="Ejemplo: Ulises" required="true" parentClass="col-12"/>
        <x-campo-formulario label="Apellidos" id="apellido_paterno" name="lastname" type="text" placeholder="Apellidos" required="true" parentClass="col-12"/>
        <x-campo-formulario label="Teléfono1" id="telefono" name="telephone" type="text" placeholder="Teléfono" required="true" parentClass="col-12"/>
        <x-campo-formulario label="Correo electrónico" id="email" name="email" type="email" placeholder="Correo Electrónico" parentClass="col-12"/>
        <x-campo-formulario label="Contraseña" id="email" name="password" type="password" placeholder="Contraseña" parentClass="col-12"/>

        <div class="col-6 pt-3">
            @php
            $opciones = array(["id"=>"Inactivo","option"=>"Inactivo"],["id"=>"Activo","option"=>"Activo"],["id"=>"Bloqueado","option"=>"Bloqueado"])
            @endphp
            <x-dropdown-formulario label="Asignar como" id="estado" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="estado" />
        </div>
        <div class="col-12 pt-3">
            <x-dropdown-formulario label="Roles disponibles" id="rol" :options="$roles" value-key="name" option-key="name" simpleArray="false" name="user_type"/>
        </div>

            
        <x-boton nombre_boton="Crear Escuela" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
    </div>
</form>

       
      
    
</div>
</div>
@endsection