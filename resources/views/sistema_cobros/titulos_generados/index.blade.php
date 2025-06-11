@extends('sistema_cobros.titulos_generados.layouts.index')
@section("content")
    <x-page-breadcrumb :titulo="$titulo_breadcrumb" :subtitulo="$subtitulo_breadcrumb" />
    <button class="btn btn-success enviar">Generar lote de títulos</button>
    @include($view,["confTabla"=>$confTabla])
@endsection