@if (isset($elemento))

    {{-- Nuestro formulario para actualizar configuraciones de secciones --}}
    <form action="{{ route("actualizar.seccion") }}" method="POST" id="actualizar_seccion">
        @csrf
        <input type="hidden" name="id" value="{{ $elemento['id'] }}">
            
        {{-- Identificar Si Es Vista Edición Y No Create--}}
            @if(isset($edicion) && $edicion==true)
                <input type="hidden" name="editar_informe" value="true">
                <input type="hidden" name="id_informe" value="{{ $id_informe??'' }}">
            @else
                <input type="hidden" name="editar_informe" value="false">
            @endif
        {{-- Vista Edición Y No Create--}}
        
        @switch($elemento["tipo"])
            @case("tabla")
                {{-- Incluir la vista para sidebar para cuando el elemento es una tabla --}}
                <h5>Configuración de tabla</h5>
                @include('sistema_cobros.informes.componentes.sidebar.query',[
                    "elemento"=>$elemento,
                    "tablas"=>$tablas,
                    "columnasPorTabla"=>$columnasPorTabla,
                    "columnas"=>$columnasPorTabla
                ])
                @break
            @case("tarjeta")
            {{-- Incluir la vista para sidebar para cuando el elemento es una tarjeta --}}
                <h5>Visualizar configuración de tarjeta</h5>           
                @include('sistema_cobros.informes.componentes.sidebar.tarjeta',["elemento"=>$elemento])
                @include('sistema_cobros.informes.componentes.sidebar.query',[
                    "elemento"=>$elemento,
                    "tablas"=>$tablas,
                    "columnasPorTabla"=>$columnasPorTabla,
                    "columnas"=>$columnasPorTabla])
                @break
            @case("texto_sm")
            {{-- Incluir la vista para sidebar para cuando el elemento es una texto --}}
                <h5>Visualizar configuración de texto</h5>
                @break
            @case("texto_md")
            {{-- Incluir la vista para sidebar para cuando el elemento es una texto--}}
                <h5>Visualizar configuración de texto</h5>
                @break
            @case("texto_lg")
            {{-- Incluir la vista para sidebar para cuando el elemento es una texto --}}
                <h5>Visualizar configuración de texto</h5>
                @break
            @case("grafica")
                <h5>Visualizar configuración de gráfica</h5>
                @include('sistema_cobros.informes.componentes.sidebar.query', [
                    "elemento" => $elemento,
                    "tablas" => $tablas,
                    "columnasPorTabla" => $columnasPorTabla,
                    "columnas" => $columnasPorTabla
                ])
                <hr>
                @include('sistema_cobros.informes.componentes.sidebar.grafica', [
                    "elemento" => $elemento
                ])
                @break

            @default
                <div class="alert alert-warning">El elemento solicitado no fue reconocido.</div>
                
        @endswitch

        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
@else

    <div class="alert alert-warning">No encontramos el id {{ $id }}</div>
   


@endif