@if (isset($show))
    @if (isset($campo["endpoint"]))
        {{-- Atributo name --}}
        @php
            $nameAttr = "input[{$tabla}][{$index}][{$campo['name']}]";
        @endphp
        {{-- Atributo name --}}
        {{-- Bloque show aquí--}}

        <label for="" class="form-label">{{ $campo["placeholder"] }}</label>
                    <select class="select2-components mt-5 mb-5 form-control"
                        data-tags="true"
                        data-placeholder="{{  $campo["placeholder"] }}"
                        data-allow-clear="true"
                        id="{{  $campo["id"] }}" 
                        name="{{  $nameAttr }}" 
                        data-endpoint="{{  $campo["endpoint"] }}"
                        data-archivo="{{ $campo["archivo"]??'' }}"
                         data-retornar='@json($campo["retornar"] ?? [])'>
                        
                        @if(isset($campo["id_seleccionado"]))
                            <option value="{{ $campo["id_seleccionado"] }}" selected>{{ $campo["texto_concatenado"]}}</option>
                        @endif
                    </select>

                    
                    @push('jquery')
                    <script>
                        $(document).ready(function(){

                        $('#{{ $campo["id"] }}').select2({
                        placeholder: '{{ $campo["placeholder"] }}',
                        ajax:{
                            type: "post",
                            dataType: "json",
                            url: "{{ route($campo["endpoint"]) }}",  {{-- NOTA: endpoint variable --}}
                            data: function (params) {
                                var query = {
                                    search: params.term,
                                    _token: '{{csrf_token()}}',
                                    type: 'public',
                                    archivo: '{{ $campo["archivo"]??'' }}'
                                }

                                // Query parameters will be ?search=[term]&type=public
                                return query;
                            },
                            processResults: function (data) {
                                // Transforms the top-level key of the response object from 'items' to 'results'
                                console.log(data);
                                    return {
                                            results: $.map(data, function (item) {
                                                return {
                                                    text: {!! json_encode($campo["retornar"]) !!}.map(col => item[col]).join(" "),
                                                    id: item.id  
                                                }
                                            })
                                    }
                            }
                        }
                        });
                        });
                    </script>
                    @endpush
                    

        {{-- Bloque show aquí--}}
    @else
        <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif

@else

        @if (isset($endpoint))
                    {{-- Variables necesarias: $placeholder, $id, $name,$endpoint, $texto, $columna_id --}}
                    <label for="" class="form-label">{{ $placeholder }}</label>
                    <select class="select2-components mt-5 mb-5 form-control"
                    data-tags="true" data-placeholder="{{ $placeholder }}" data-allow-clear="true" id="{{ $id }}" name="{{ $name }}">
                        @if(isset($id_seleccionado))
                            <option value="{{ $id_seleccionado }}" selected>{{ $texto_concatenado ?? ''}}</option>
                        @endif
                    </select>

                    @if(!isset($ejemplo))
                        @push('jquery')
                        <script>
                            $(document).ready(function(){

                            $('#{{ $id }}').select2({
                            placeholder: '{{ $placeholder }}',
                            ajax:{
                                type: "post",
                                dataType: "json",
                                url: "{{ route($endpoint) }}",  {{-- NOTA: endpoint variable --}}
                                data: function (params) {
                                    var query = {
                                        search: params.term,
                                        _token: '{{csrf_token()}}',
                                        type: 'public',
                                        archivo: '{{ $archivo??'' }}'
                                    }

                                    // Query parameters will be ?search=[term]&type=public
                                    return query;
                                },
                                processResults: function (data) {
                                    // Transforms the top-level key of the response object from 'items' to 'results'
                                    console.log(data);
                                        return {
                                                results: $.map(data, function (item) {
                                                    return {
                                                        text: {!! json_encode($retornar) !!}.map(col => item[col]).join(" "),
                                                        id: item.id  
                                                    }
                                                })
                                        }
                                }
                            }
                            });
                            });
                        </script>
                        @endpush
                    @else

                    <script>
                        $(document).ready(function(){
                            console.log("hola");
                        $('#{{ $id }}').select2({
                        placeholder: '{{ $placeholder }}',
                        ajax:{
                            type: "post",
                            dataType: "json",
                            url: "{{ route($endpoint) }}",  {{-- NOTA: endpoint variable --}}
                            data: function (params) {
                                var query = {
                                    search: params.term,
                                    _token: '{{csrf_token()}}',
                                    type: 'public'
                                }

                                // Query parameters will be ?search=[term]&type=public
                                return query;
                            },
                            processResults: function (data) {
                                // Transforms the top-level key of the response object from 'items' to 'results'
                                console.log(data);
                                    return {
                                            results: $.map(data, function (item) {
                                                return {
                                                    text: {!! json_encode($retornar) !!}.map(col => item[col]).join(" "),
                                                    id: item.id  
                                                }
                                            })
                                    }
                            }
                        }
                        });
                        });
                    </script>


                    @endif
                    
                @else
                    <div class="alert alert-warning">
                        No obtuvimos los datos completos para correr la pre-visualización
                    </div>
                @endif

@endif




