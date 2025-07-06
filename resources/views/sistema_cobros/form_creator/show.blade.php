@extends('sistema_cobros.form_creator.layouts.show')
@section("content")
 
@if(Auth::user()->can($permiso) || Auth::user()->hasRole(["Administrador tecnológico","Owner"]))
    

@include('components.sistema_cobros.response')
<a href="{{ route('form_creator.index') }}" class="btn btn-primary my-5">Regresar al listado de formularios</a>
<div class="card">
    <div class="card-header pt-3">
        <h5>{{ $titulo ?? '' }}</h5>
        <p>{{ $descripcion ?? '' }}</p>
    </div>
    <div class="card-body mx-5">
        <form class="display-form-inputs" method="post" action="{{ isset($action) ? route($action) : '' }}" enctype="multipart/form-data">
            @csrf
            <x-lista-mensajes/>
            <input type="hidden" name="identificador_action" value="{{ $hidden_identifier ?? '' }}">
            <input type="hidden" name="nombre_documento" value="{{ $nombre_documento ?? '' }}">
            {{-- USO: ITERACIÓN Para poner cada componente de formulario --}}
            <div class="contenedor_registros"> 
               
                <div class="bloque_registro">

                    <button type="button" class="btn btn-outline-danger btn-sm eliminar-bloque d-none">
                        🗑 Eliminar
                    </button>
                    <div class="row">
            @foreach ($inputs as $index=>$input)
                   {{-- bloque de inputs --}}
                    
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
                    </div>
                  </div>
            </div>
             {{-- USO:  Para poner cada componente de formulario --}}
          
            @if(isset($multiples_registros) && $multiples_registros)
                <button class="btn btn-success add-registro" type="button">+</button>
            @endif


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

{{-- MULTI Registro--}}
@push('eventos_multiregistro')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const multiplesRegistros = {{ $multiples_registros ? 'true' : 'false' }};

        if (multiplesRegistros) {
            inicializarFuncionesMultiRegistro();
        }

         // ✅ Inicializa flatpickr en los bloques existentes al cargar
        inicializarFlatpickrEn($(document));

      

       function inicializarFuncionesMultiRegistro() {
    $(document).on('click', '.add-registro', function (e) {
        e.preventDefault();

        let bloqueOriginal = $('.bloque_registro').last();

        // 🧼 Destruye Select2 solo para clonar limpio
        bloqueOriginal.find('.select2-components').select2('destroy');

        // ✅ Clona HTML sin instancias activas
        let nuevoBloque = $(bloqueOriginal[0].outerHTML);

        // 🧼 Limpia rastros de Flatpickr generados
        nuevoBloque.find('input.flatpickr-input:not([name])').remove();
        nuevoBloque.find('input.form-control[readonly]:not([name])').remove();

        // 🧼 Limpia residuos visuales de Select2
        nuevoBloque.find('.select2-container').remove();

        // ✅ Reindexar
        let index = $('.contenedor_registros .bloque_registro').length;
        nuevoBloque.find('input, select, textarea').each(function () {
            let name = $(this).attr('name');
            if (name) {
                $(this).attr('name', name.replace(/\[\d+\]/, `[${index}]`));
            }
            if ($(this).is(':checkbox') || $(this).is(':radio')) {
                $(this).prop('checked', false);
            } else {
                $(this).val('');
            }
        });

        // ➕ Agregar nuevo bloque
        $('.contenedor_registros').append(nuevoBloque);

        // ✅ Re-inicializar ambos
        inicializarSelect2En(bloqueOriginal); // 👈 reinicia original
        inicializarSelect2En(nuevoBloque);    // 👈 inicializa el nuevo

        inicializarFlatpickrEn(nuevoBloque);
        eventoEliminarBloque();

        nuevoBloque.find('.eliminar-bloque').removeClass('d-none');
    });
}



        function eventoEliminarBloque() {
            $(document).off('click', '.eliminar-bloque').on('click', '.eliminar-bloque', function () {
                if ($('.bloque_registro').length <= 1) {
                    alert('Debe haber al menos un bloque.');
                    return;
                }

                $(this).closest('.bloque_registro').remove();

                // Reindexar todos los bloques
                $('.bloque_registro').each(function (i) {
                    $(this).find('input, select, textarea').each(function () {
                        let name = $(this).attr('name');
                        if (name) {
                            $(this).attr('name', name.replace(/\[\d+\]/, `[${i}]`));
                        }
                    });
                });

                if ($('.bloque_registro').length === 1) {
                    $('.bloque_registro').first().find('.eliminar-bloque').addClass('d-none');
                }
            });
        }

        function inicializarFlatpickrEn(bloque) {
            // datetime (fecha + hora)
                bloque.find('.flatpickr-datetime').each(function () {
                    const input = this;
                    const formato = input.dataset.formato || 'Y-m-d H:i';
                    if (input._flatpickr) input._flatpickr.destroy();

                    flatpickr(input, {
                        altInput: true,
                        enableTime: true,
                        dateFormat: formato,
                        locale: 'es'
                    });
                });

                // solo date
                bloque.find('.flatpickr-date').each(function () {
                    const input = this;
                    const formato = input.dataset.formato || 'Y-m-d';
                    if (input._flatpickr) input._flatpickr.destroy();

                    flatpickr(input, {
                        altInput: true,
                        dateFormat: formato,
                        locale: 'es'
                    });
                });

                // solo time
                bloque.find('.flatpickr-time1').each(function () {
                    const input = this;
                    const formato = input.dataset.formato || 'H:i';
                    if (input._flatpickr) input._flatpickr.destroy();

                    flatpickr(input, {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: formato,
                        locale: 'es'
                    });
                });
        }


        function inicializarSelect2En(bloque) {
            bloque.find('.select2-components').each(function () {
                 let $select = $(this);
                console.log($select.data('placeholder'));
                console.log($select.data('endpoint'));
                console.log($select.data('archivo'));
                console.log($select.data('retornar'));
                if ($(this).attr('id')) {
                    $(this).removeAttr('id');
                }


                $select.select2({
                    placeholder: $select.data('placeholder'),
                    ajax: {
                        url: "/select2/"+$select.data('endpoint'),
                        type: 'POST',
                        dataType: 'json',
                        data: function (params) {
                            return {
                                search: params.term,
                                _token: '{{ csrf_token() }}',
                                archivo: $select.data('archivo') || ''
                            };
                        },
                        processResults: function (data) {
                            let columnas = $select.data('retornar') || ['nombre'];
                            return {
                                results: data.map(item => ({
                                    id: item.id,
                                    text: columnas.map(col => item[col]).join(' ')
                                }))
                            };
                        }
                    }
                });
            });
        }
    });
</script>

@endpush
{{-- MULTI Registro--}}

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


