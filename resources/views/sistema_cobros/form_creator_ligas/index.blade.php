@extends('sistema_cobros.form_creator_ligas.layouts.index')
@section("content")
    <x-page-breadcrumb :titulo="$titulo_breadcrumb" :subtitulo="$subtitulo_breadcrumb" />
    @include($view,["confTabla"=>$confTabla])
@endsection