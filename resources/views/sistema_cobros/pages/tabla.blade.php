@extends('sistema_cobros.layouts.tablas')
@section("content")
    <x-page-breadcrumb :titulo="$titulo_breadcrumb" :subtitulo="$subtitulo_breadcrumb" />

    

    @if(isset($tabla))
        <a href="{{ (is_array($confTabla['routeCreate']))?route($confTabla['routeCreate'][0],$confTabla['routeCreate'][1]):route($confTabla['routeCreate']); }}" class="btn btn-primary float-end">Crear +</a>
        @switch($tabla)
            @case("tabla.escuelas")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.sistemas_academicos")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.alumnos")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.conceptos_cobros")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.costos_conceptos")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.cuentas")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.usuarios")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.roles")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.permisos")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.categoria_cobros")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.descuentos")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.pagos_pendientes")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.pagos_realizados")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.promociones")
                @include($view,["confTabla"=>$confTabla])
                @break
            @default
        @endswitch
        
        
    @endif
    
@endsection