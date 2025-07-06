@extends('sistema_cobros.form_creator.layouts.show')
@section("content")

    @if (isset($respuesta))
        {{ print_r($respuesta) }}
    @endif
@endsection