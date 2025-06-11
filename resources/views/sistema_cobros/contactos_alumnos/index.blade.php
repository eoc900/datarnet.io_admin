@extends('sistema_cobros.tipos_correos.layouts.index')
@section("content")
    <x-page-breadcrumb :titulo="$titulo_breadcrumb" :subtitulo="$subtitulo_breadcrumb" />
    @include($view,["confTabla"=>$confTabla])
@endsection