@extends('sistema_cobros.form_creator_ligas.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Crear una nueva liga</h5>
</div>
<div class="card-body">
          <div class="alert alert-success border-0 bg-grd-info alert-dismissible fade show">
                <div class="d-flex align-items-center">
                        <div class="font-35 text-white"><i class="fa-light fa-link"></i>

                        </div>
                        <div class="ms-3">
                        <h6 class="mb-0 text-white">Uso:</h6>
                        <div class="text-white">Las ligas sirven para hacer enlaces personalizados de formularios públicos</div>
                </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <form class="row" method="post" action="{{ route('ligas_formulario.store') }}" enctype="multipart/form-data" id="guardar_formulario">
        @csrf
        <x-lista-mensajes/>
        <div class="col-sm-6 py-3">
                <label class="form-label" for="formularios_disponibles">Selecciona el formulario</label>
                <x-select2 placeholder="Buscar usuario o rol" id="formularios_disponibles" name="formulario_id" />
        </div>
       

        <div class="col-sm-6 py-3">
                <label class="form-label">Slug</label>
                <input type="text" name="slug"  class="form-control" required>
        </div>

        <div class="col-sm-6 py-3">
                <label class="form-label">Fecha de apertura (opcional)</label>
                <input type="text" class="form-control date-1" name="fecha_apertura">
        </div>

        <div class="col-sm-6 py-3">
                <label class="form-label">Fecha cierre (opcional)</label>
                <input type="text" class="form-control date-2" name="fecha_cierre">
        </div>

        <div class="col-12 pt-3">
                @php
                        $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
                @endphp
                <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activa" />
        </div>

        <div class="col-sm-6 py-3">
                <label class="form-label">Limitar respuestas</label>
                <input type="number" name="max_respuestas"  class="form-control">
        </div>

         <div class="col-12 pt-3">
                @php
                        $opciones = array(["id"=>0,"option"=>"Sin token"],["id"=>1,"option"=>"Requerido"])
                @endphp
                <x-dropdown-formulario label="Requiere token" id="token" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="requiere_token" />
        </div>
        
         <div class="col-sm-6 py-3">
                <label class="form-label">Redireccionar a url</label>
                <input type="text" name="redirect_url"  class="form-control" >
        </div>
        <div class="col-sm-12 py-3">
                 <label class="form-label">Notas del admin</label>
                <textarea class="form-control" name="notas_admin" id="" cols="30" rows="5"></textarea>
        </div>
        
      
        <x-boton nombre_boton="Generar formulario" type="submit" classes="btn-submit btn btn-success float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection

@push("input_calendario")
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
        <script>
        $(document).ready(function(){
                $(".date-1").flatpickr({
                                        enableTime: true,
                                        dateFormat: "Y-m-d",
                });
                $(".date-2").flatpickr({
                                        enableTime: true,
                                        dateFormat: "Y-m-d",
                });

              
       
        <x-script-select2 select2="select2/formularios" idSelect2="formularios_disponibles">
        text: "Título: "+item.titulo,
        id: item.id,
        </x-script-select2>

        <x-select2-on-select idSelect2="formularios_disponibles" >
                console.log(e.params.data.id);
        </x-select2-on-select>
             
               
        });
        </script>
@endpush