{{-- 
    Parametros que necesitamos para llamar a este componente 
    1. Columnas encontradas en la tabla
    2. Tabla donde se busca
    3. Clase donde se van a pegar los resultados de tabla
--}}


@if (!empty($columnas) && isset($tabla) && isset($clase_contenedor))
<div class="input-group">
    <input type="text" class="form-control" placeholder="Ingresa el valor a buscar" id="buscar_en">
    <select name="columnas" id="columna" class="form-control">
        @foreach ($columnas as $columna)
            <option value="{{ $columna }}">{{ $columna }}</option>
        @endforeach
    </select>
    <button type="button" class="btn btn-primary" id="btn_buscar">Buscar</button>
</div>


@push("buscar_una_columna")
    <script>
        function ajaxBuscarSolaColumna(valor,columna){
            $.ajax({
                url: '/ajax/form_creator_buscar_sola_columna',
                type: 'post',
                data:{_token: '{{csrf_token()}}',buscar:valor,tabla:"{{ $tabla }}",columna:columna},
                success:function(response){
                    console.log("buscando el valor: "+valor);
                    console.log(response);
                    $("{{ $clase_contenedor }}").html(response);
                }
            })
        }

        function buscarSolaColumna(){
            $("#btn_buscar").off();
            $("#btn_buscar").click(function(){
                ajaxBuscarSolaColumna($("#buscar_en").val(),$("#columna").val());
            });
        }
    </script>
@endpush


@endif