@extends('sistema_cobros.form_creator.layouts.show')
@section("content")
 
@if(auth::user()->can($permiso) || auth::user()->hasRole(["Administrador tecnológico","Owner"]))
    

@include('components.sistema_cobros.response')
<a href="{{ route('form_creator.index') }}" class="btn btn-primary my-5">Regresar al listado de formularios</a>
<div class="card">
    <div class="card-header pt-3">
        <h5>{{ $titulo ?? '' }}</h5>
        <p>{{ $descripcion ?? '' }}</p>
    </div>
    <div class="card-body mx-5">
        <form class="row" method="post" action="{{ isset($action) ? route($action) : '' }}" enctype="multipart/form-data">
            @csrf
            <x-lista-mensajes/>
            <input type="hidden" name="identificador_action" value="{{ $hidden_identifier ?? '' }}">
            <input type="hidden" name="nombre_documento" value="{{ $nombre_documento ?? '' }}">
            {{-- USO: ITERACIÓN Para poner cada componente de formulario --}}
            @foreach ($inputs as $index=>$input)
                
                @if ($input["type"]=="text")
                    <div class="col-sm-6 mt-3">
                    @include("components.form_creator.ejemplos_inputs.text",["campo"=>$input,"show"=>true,"tabla"=>$tabla,"index"=>0])
                    </div>
                @endif
                @if ($input["type"]=="date")
                    <div class="col-sm-4 mt-3">
                    @include("components.form_creator.ejemplos_inputs.date",["campo"=>$input,"show"=>true,"tabla"=>$tabla,"index"=>0])
                    </div>
                @endif
                @if ($input["type"]=="time")
                    <div class="col-sm-4 mt-3">
                    @include("components.form_creator.ejemplos_inputs.time",["campo"=>$input,"show"=>true,"tabla"=>$tabla,"index"=>0])
                    </div>
                @endif
                @if ($input["type"]=="datetime")
                    <div class="col-sm-4 mt-3">
                    @include("components.form_creator.ejemplos_inputs.datetime",["campo"=>$input,"show"=>true,"tabla"=>$tabla,"index"=>0])
                    </div>
                @endif
                @if ($input["type"]=="select2")
                    <div class="col-sm-6 mt-3">
                    @include("components.form_creator.ejemplos_inputs.select2",["campo"=>$input,"show"=>true,"tabla"=>$tabla,"index"=>0])
                    </div>
                @endif
                @if ($input["type"]=="dropdown")
                    <div class="col-sm-6 mt-3">
                    @include("components.form_creator.ejemplos_inputs.dropdown",["campo"=>$input,"show"=>true,"tabla"=>$tabla,"index"=>0])
                    </div>
                @endif
                @if ($input["type"]=="radio")
                    <div class="col-sm-6 mt-3">
                    @include("components.form_creator.ejemplos_inputs.radio",["campo"=>$input,"show"=>true,"tabla"=>$tabla,"index"=>0])
                    </div>
                @endif
                @if ($input["type"]=="email")
                    <div class="col-sm-6 mt-3">
                    @include("components.form_creator.ejemplos_inputs.email",["campo"=>$input,"show"=>true,"tabla"=>$tabla,"index"=>0])
                    </div>
                @endif
                @if ($input["type"]=="file")
                    <div class="col-sm-6 mt-3">
                    @include("components.form_creator.ejemplos_inputs.file",["campo"=>$input,"show"=>true,"tabla"=>$tabla,"index"=>0])
                    </div>
                @endif
                @if ($input["type"]=="checkbox")
                    <div class="col-sm-6 mt-3">
                    @include("components.form_creator.ejemplos_inputs.checkbox",["campo"=>$input,"show"=>true,"tabla"=>$tabla,"index"=>0])
                    </div>
                @endif
                @if ($input["type"]=="hidden")
                    <div class="col-sm-6 mt-3">
                    @include("components.form_creator.ejemplos_inputs.hidden",["campo"=>$input,"show"=>true,"tabla"=>$tabla,"index"=>0])
                    </div>
                @endif
                @if ($input["type"]=="multi-item")
                    <div class="col-sm-12 mt-3">
                    <hr>
                    <p>{{ $input["descripcion_subformulario"] }}</p>                
                    @include("components.form_creator.ejemplos_inputs.multi_item",$input)
                    </div>
                @endif
              
            @endforeach
             {{-- USO:  Para poner cada componente de formulario --}}
          


            <x-boton 
                nombre_boton="Insertar formulario" 
                type="submit" 
                classes="btn-submit btn btn-success float-end" 
                parentClass="col-12 pt-5 float-end"
            />
        </form>
    </div>
</div>
@else

    <div class="alert alert-warning">
        <p>Lo sentimos no tienes acceso para visualizar este formulario</p>
    </div>
@endif
@endsection

{{-- MULTI ITEM --}}
<script>
@push("eventos_funciones_multi_item")
    let subIndex = 1; // Empieza en 1 porque el 0 ya está en la vista

    function eventoClickRegistroMultiple(){
        $(".agregar_registro_multiple").off();
        $(document).on('click', '.agregar_registro_multiple', function () {
            // Paso 1: detectar el botón y su contenedor principal (puedes ajustar el selector si cambia)
            let contenedorPrincipal = $(this).closest('.row');

            // Paso 2: encontrar cuántos bloques .hilera_inputs existen en ese contenedor
            let hilerasContainer = contenedorPrincipal.find('#hilera_inputs');
            let totalHileras = hilerasContainer.find('.hilera_input').length;

            // Paso 3: clonar la última hilera
            let hileraOriginal = hilerasContainer.find('.hilera_input').last();
            let nuevaHilera = hileraOriginal.clone();

            // Paso 4: limpiar valores y actualizar el índice en los name
            nuevaHilera.find('input, select, textarea').each(function () {
                let name = $(this).attr('name');
                if (name) {
                    // Actualizar el índice entre [N]
                    let newName = name.replace(/\[\d+\]/, `[${totalHileras}]`);
                    $(this).attr('name', newName);
                }

                // NO limpiar si es llave foránea
                if ($(this).hasClass('llave_foranea')) {
                    return; // salir del .each() para este elemento
                }

                // Limpiar valores
                if ($(this).is(':checkbox') || $(this).is(':radio')) {
                    $(this).prop('checked', false);
                } else if ($(this).is('input[type="file"]')) {
                    $(this).val('');
                } else {
                    $(this).val('');
                }
            });


            // Paso 5: insertar la nueva hilera al final del contenedor
            hilerasContainer.append(nuevaHilera);
            eventoClickEliminar();
        });
    }

    function eventoClickEliminar(){
        $('.eliminar_hilera').off();
        $(document).on('click', '.eliminar_hilera', function () {
            let contenedorPrincipal = $(this).closest('.row');
            let hilerasContainer = contenedorPrincipal.find('#hilera_inputs');

            // Elimina la hilera
            $(this).closest('.hilera_input').remove();

            // Recalcular índices
            hilerasContainer.find('.hilera_input').each(function (nuevoIndex) {
                $(this).find('input, select, textarea').each(function () {
                    let name = $(this).attr('name');
                    if (name) {
                        let newName = name.replace(/\[\d+\]/, `[${nuevoIndex}]`);
                        $(this).attr('name', newName);
                    }
                });
            });
        });
    }

    eventoClickRegistroMultiple();
    

@endpush
</script>


