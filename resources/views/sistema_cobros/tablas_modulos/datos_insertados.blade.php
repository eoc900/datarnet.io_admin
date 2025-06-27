@extends('sistema_cobros.tablas_modulos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')  

@if (!isset($show))
    <div class="alert alert-success">La tabla {{ $tabla??'' }} fue generada con éxito</div>
@endif





@if (!empty($excel))
    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                @foreach (array_keys($excel[0]) as $columna)
                    <th>{{ ucwords(str_replace('_', ' ', strtolower($columna))) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($excel as $fila)
                <tr>
                    @foreach ($fila as $valor)
                        <td>{{ $valor }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No hay datos disponibles.</p>
@endif




@endsection