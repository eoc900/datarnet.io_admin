@extends('administrador.usuarios.layouts.select2_layout')
@section("content")

    <x-page-breadcrumb :titulo="$titulo_breadcrumb" :subtitulo="$subtitulo_breadcrumb" />

     <div class="col-md-12 mt-4">
           @include('components.sistema_cobros.response')

           <div id="alertas">

           </div>
            

            <h5 class="usuario_seleccionado mt-5" data-usuario=""></h5>

            <div class="listado_roles mt-5">            
            </div>
            
            <div class="seccion_agregar_roles mt-5">
                <div class="card px-5">
                    <div class="card-body">
                        <h4 class="mt-5"><i class="fa-solid fa-user"></i> Selecciona a un usuario</h4>
                        <label for="{{ $idSelect2 }}">Selecciona el concepto</label>
                        <x-select2 placeholder="Buscar usuario o rol" id="{{ $idSelect2 }}" name="id_usuario" />
                         <form action="{{ route('agregar.rol.usuario') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="usuario" name="user_id" />
                                <x-campo-formulario id="hidden_input" name="hidden_input" value="generar_rol_usuario" type="hidden" placeholder="" required="true" parentClass="col-12"/>                    
                                <x-dropdown-formulario label="Roles Disponibles" id="filtroBusqueda" :options="$roles" value-key="name" option-key="name" simpleArray="false" name="rol" />
                                <x-boton nombre_boton="Insertar rol" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
                            </form>
                            
                    </div>
                </div>
             
            </div>
    </div>

@endsection