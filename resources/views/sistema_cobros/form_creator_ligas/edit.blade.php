@extends('sistema_cobros.form_creator.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Editar formulario</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('form_creator.update',$form->id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <x-lista-mensajes/>
        <div class="row">
        <div class="col-md-6">
            <label for="" class="form-label">Título de formulario</label>
            <input type="text" name="titulo" value="{{ $form->titulo }}" class="form-control">
        </div>
        <div class="col-md-6">
            <label for="" class="form-label">Clave de formulario</label>
            <input type="text" name="hidden_identifier" value="{{ $form->hidden_identifier }}" class="form-control">
        </div>
        <div class="col-md-6 mt-2">
            <label for="" class="form-label">Descripción</label>
            <textarea name="descripcion" id="" cols="30" rows="5" class="form-control">{{ $form->descripcion }}</textarea>
        </div>
        <div class="col-md-6 mt-2">
            <label for="" class="form-label">Ruta controlador</label>
            <input type="text" name="action" value="{{ $form->action }}" class="form-control">
        </div>
        <div class="col-md-6 mt-3">
            <label for="" class="form-label">Nombre del documento</label>
            <input type="text" name="action" value="{{ $form->nombre_documento }}" class="form-control">
        </div>
        <div class="col-md-6">
            @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp
            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" :selected="$form->activo" />
        </div>


        <div class="contenedor_campos bg-light">
            {{-- Aquí se agregan las configuraciones de todos los inputs --}}
        </div>


         <x-boton nombre_boton="Editar categoría" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection

@push('funciones_editar')
      // Sección editar
      function ajaxBringInputs(nombre){
          $.ajax({
                  url: '{{ route("ajax.render_inputs_edit") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',documento:nombre},
                  success: function(response){
                    console.log(response);
                    $(".campos-configuracion").append(response);
                    eventoClickSeleccionarTabla();
                    eventoClickPrevisualizar();
                    removeConfigInput();
                  }
          });
      }
      ajaxBringInputs("{{ $form->nombre_documento }}");
@endpush