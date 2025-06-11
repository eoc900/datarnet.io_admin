@extends('administrador.usuarios.layouts.select2_layout')
@section("content")

    <x-page-breadcrumb :titulo="$titulo_breadcrumb" :subtitulo="$subtitulo_breadcrumb" />

     <div class="col-md-12 mt-4">
            <x-lista-mensajes />
            @if (session("code"))
                {{ print_r(session("code")); }}
            @endif
            <h4><i class="fa-solid fa-user"></i> Selecciona a un usuario</h4>


            <label for="{{ $idSelect2 }}">Selecciona el concepto</label>
            <x-select2 placeholder="Buscar usuario o rol" id="{{ $idSelect2 }}" name="id_usuario" />

            <h5 class="usuario_seleccionado mt-5" data-usuario=""></h5>

            <div class="listado_roles mt-5">
               
            </div>
            <div class="seccion_agregar_roles d-flex">
                <x-form-in-card titulo="Selecciona a un Usuario para asignarle un rol." :route="$routeStore" :accion="$accion" >
                    <x-tag-formulario name="formulario" type="hidden" value="{{ $formulario }}"/>
                    <input type="hidden" class="usuario mt-5" name="user_id" />

            <x-campo-formulario id="hidden_input" name="hidden_input" value="generar_rol_usuario" type="hidden" placeholder="" required="true" parentClass="col-12"/>
            <x-campo-formulario label="Código" id="codigo" name="code" type="text"  placeholder="codigo maestro" required="true" parentClass="col-12"/>
                    <x-dropdown-formulario label="Roles Disponibles" id="filtroBusqueda" :options="$roles" value-key="name" option-key="name" simpleArray="false" name="rol" />
                     <x-boton nombre_boton="Insertar rol" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
                </x-form-in-card>
            </div>
    </div>

@endsection