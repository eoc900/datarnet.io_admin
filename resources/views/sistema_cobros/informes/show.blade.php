@extends('sistema_cobros.informes.layouts.show')
@section("content")
@include('components.sistema_cobros.response')

@php
    
    // Tipo de buscador en el header
    $tipo = '';
    $resultados_drop = $filtros["text"]["resultados"] ?? '';

@endphp


@if(Auth::user()->can($permiso) || Auth::user()->hasRole(["Administrador tecnológico","Owner"]))
<div class="card">
    <div class="card-header pt-3">
        <h5>{{ $titulo ?? '' }}</h5>
    </div>
     <div class="card-body mx-5 p-4 mb-5">
         <div class="row mt-3 mb-5">
            
             {{-- Filtros que se pueden activar --}}
             @if(isset($filtros["personalizado"]) && count($filtros["personalizado"])>0)
                    @foreach ($filtros["personalizado"] as $filtro)
                        
                        @switch($filtro["tipo"])
                                @case('dropdown')
                                    <div class="col-md-4">
                                    @php
                                        $valores = $filtro['resultados_valores'] ?? [];
                                        $textos = $filtro['resultados_texto'] ?? [];
                                    @endphp

                                    @if(count($valores) > 0)
                                        <div class="mb-3">
                                            <label for="{{ $filtro['url_param'] ?? 'dropdown_' . $loop->index }}" class="form-label">
                                                {{ $filtro['label'] ?? 'Selecciona una opción' }}
                                            </label>

                                            <select 
                                                name="filtros[{{ $filtro['url_param'] ?? 'param_' . $loop->index }}]" 
                                                id="{{ $filtro['url_param'] ?? 'dropdown_' . $loop->index }}" 
                                                class="data-param form-select"
                                                data-param="{{ $filtro['url_param'] ?? '' }}">
                                                <option value="">-- Selecciona --</option>
                                                @foreach ($valores as $i => $valor)
                                                    <option value="{{ $valor }}"
                                                        @if(isset($filtro['seleccionado']) && $filtro['seleccionado'] == $valor) selected @endif>
                                                        {{ $textos[$i] ?? 'Opción sin texto' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            No se encontraron resultados para este filtro.
                                        </div>
                                    @endif
                                    </div>
                                @break  
                               @case('select2')
                                    <div class="col-md-4">
                                        <div class="mb-3">                   
                                            <label for="{{ $filtro['id'] }}" class="form-label data-param">{{ $filtro['label'] ?? 'Selecciona una opción' }}</label>
                                            <select id="{{ $filtro['id'] }}"
                                                    name="filtros[{{ $filtro['url_param'] ?? 'param_' . $loop->index }}]"
                                                    class="form-select select2"
                                                    data-param="{{ $filtro['url_param'] ?? '' }}">
                                                @if(isset($filtro['seleccionado']))
                                                    <option value="{{ $filtro['seleccionado'] }}" selected>
                                                        {{ $filtro['seleccionado_texto'] ?? 'Seleccionado' }}
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    @push('jquery')
                                    <script>
                                    $(document).ready(function () {
                                        // Solo uno por filtro (para evitar múltiples inicializaciones)
                                        $('#{{ $filtro["id"] }}').select2({
                                            placeholder: '{{ $filtro["placeholder"] ?? "Buscar..." }}',
                                            ajax: {
                                                type: "post",
                                                dataType: "json",
                                                url: "{{ route($filtro["endpoint"]) }}",
                                                data: function (params) {
                                                    return {
                                                        search: params.term,
                                                        '_token': '{{ csrf_token() }}',
                                                        type: 'public',
                                                        archivo: '{{ $clave_informe ?? "" }}',
                                                        id: '{{ $filtro['id'] ?? "" }}'
                                                    };
                                                },
                                                processResults: function (data) {
                                                    return {
                                                        results: $.map(data, function (item) {
                                                            return {
                                                                text: item.text,
                                                                id: item.id
                                                            };
                                                        })
                                                    };
                                                }
                                            }
                                        });

                                        // Si existe valor precargado, asegúrate que quede aplicado en select2
                                        @if(isset($filtro['seleccionado']))
                                            $('#{{ $filtro["id"] }}').val('{{ $filtro["seleccionado"] }}').trigger('change');
                                        @endif
                                    });
                                    </script>
                                    @endpush

                                @break
                                @case('campo_texto_abierto')
                                    <div class="alert alert-warning">Aquí hay un campo de texto abierto</div>
                                @break
                                @case('fechas')
                                    <div class="col-md-12">
                                    @include("sistema_cobros.informes.componentes.show.date_filter",[
                                    "default_end"=>$default_end,
                                    "default_start"=>$default_start])
                                    </div>
                                @break                         
                                @default
                                
                        @endswitch    
                    
                    @endforeach
                   

            @else


                @foreach ($filtros as $index=>$filtro)            
                            @if ($index=="text")
                                @if($filtro["mode"]==="select2")
                                    @php
                                        $tipo="select2"
                                    @endphp
                                    @include("components.form_creator.ejemplos_inputs.select2",$filtro)
                                @endif
                                @if($filtro["mode"]==="tabla_enlazada")
                                    @php
                                        $tipo="dropdown"
                                    @endphp

                            
                                    @include("components.form_creator.ejemplos_inputs.dropdown",[
                                            "resultados"=>$resultados_drop ,
                                            "label"=>$filtro["label"],
                                            "name"=>"dropdown",
                                            "class"=>"buscador_dropdown",
                                            "simple_dropdown"=>true
                                        ])
                                @endif
                            @endif
                            @if ($index=="date")
                                @include("sistema_cobros.informes.componentes.show.date_filter",[
                                    "default_end"=>$default_end,
                                    "default_start"=>$default_start])
                            @endif
                    
                @endforeach
            @endif
            {{-- Filtros que se pueden activar --}}
            <div class="col-12"><button type="filtrar" id="filtrar" class="btn btn-primary float-end">Filtrar</button>   <a href="{{ route('informes.show', ['informe' => $clave_informe ?? $id]) }}" class="btn btn-outline-secondary">
                Limpiar filtros
            </a></div>
           
         


        </div>
        <hr>
   
        <div class="row">
        @foreach ($secciones as $seccion)
            @switch($seccion["tipo"])
                @case("tabla")
                    @if(isset($seccion["query"]["raw_sql"]))
                    @include('sistema_cobros.informes.componentes.show.tabla_sql', [
                        "registros" => $seccion["resultados"],
                        "seccion" => $seccion
                    ])
    @else
        @include('sistema_cobros.informes.componentes.show.tabla_dinamica', [
            "registros" => $seccion["resultados"],
            "seccion" => $seccion
        ])
    @endif
                @break
                @case("tarjeta")
                    @include('sistema_cobros.informes.componentes.show.tarjeta_dinamica',[
                        "registros"=>$seccion["resultados"],
                        "tarjeta_titulo"=>$seccion["tarjeta_titulo"],
                        'seccion' => $seccion])
                @break
                @case("grafica")

                    @if(isset($seccion["query"]["raw_sql"]))
                        @include('sistema_cobros.informes.componentes.show.grafica_multiples_series', [
                                'seccion' => $seccion
                        ])
                    @else
                        @include('sistema_cobros.informes.componentes.show.grafica_dinamica', [
                                'seccion' => $seccion
                        ])
                    @endif
                    
                @break
            @default
            @endswitch
        @endforeach
        </div>
   

     </div>
</div>
@else

    <div class="alert alert-warning">
        <p>Lo sentimos no tienes acceso para visualizar este informe</p>
    </div>


@endif




@endsection





@push('filtros_funciones_show')

eventoActivarFiltrado();
function eventoActivarFiltrado() {
  $('#filtrar').on('click', function () {
    const params = {};

    // Buscar todos los elementos que tengan el atributo data-param
    $('[data-param]').each(function () {
      const clave = $(this).data('param');
      const valor = $(this).val();
      if (clave && valor !== undefined && valor !== null && valor !== '') {
        params[clave] = valor;
      }
    });

    // Generar nueva URL conservando la ruta actual sin parámetros
    const url = new URL(window.location.href.split('?')[0]);

    // Agregar los parámetros al querystring
    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));

    // Redirigir a la misma vista con los nuevos filtros
    window.location.href = url.toString();
  });

}

@endpush
