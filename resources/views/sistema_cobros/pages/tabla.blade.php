@extends('sistema_cobros.layouts.tablas')
@section("content")
    <x-page-breadcrumb :titulo="$titulo_breadcrumb" :subtitulo="$subtitulo_breadcrumb" />

    

    @if(isset($tabla))
        <a href="{{ (is_array($confTabla['routeCreate']))?route($confTabla['routeCreate'][0],$confTabla['routeCreate'][1]):route($confTabla['routeCreate']); }}" class="btn btn-primary float-end">Crear +</a>
        @switch($tabla)          
            @case("tabla.usuarios")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.roles")
                @include($view,["confTabla"=>$confTabla])
                @break
            @case("tabla.permisos")
                @include($view,["confTabla"=>$confTabla])
                @break          
            @default
        @endswitch
        
        
    @endif
    
@endsection