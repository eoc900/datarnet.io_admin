@extends('sistema_cobros.carga_materias.layouts.index')
@section("content")
    <x-page-breadcrumb :titulo="$titulo_breadcrumb" :subtitulo="$subtitulo_breadcrumb" />
    @include($view,["confTabla"=>$confTabla])
@endsection