@extends('general.layouts.index')
@section("content")
    <x-page-breadcrumb :titulo="$titulo_breadcrumb" :subtitulo="$subtitulo_breadcrumb" />
    <a href="{{ route('permisos.create') }}" class="btn btn-primary float-end">Crear +</a>
    @include($view,["confTabla"=>$confTabla])
@endsection