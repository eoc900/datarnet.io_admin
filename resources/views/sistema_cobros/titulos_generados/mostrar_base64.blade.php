@extends('sistema_cobros.titulos_generados.layouts.base64')
@section("content")

@include('components.sistema_cobros.response')

<div class="card">
    <div class="card-body">
            <h1>Contenido Base64 del archivo: {{ $filename }}</h1>
            <h5>Lote: {{ $lote }}</h5>
            <textarea readonly style="width: 100%; height: 300px; font-family: monospace;">
                {{ $base64Content }}
            </textarea>
            <p>Si la descarga no comienza automáticamente, <a href="{{ $downloadUrl }}">haz clic aquí</a>.</p>
    </div>
</div>


@endsection