@extends('sistema_cobros.tablas_modulos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')  

@if (!isset($show))
    <div class="alert alert-success">La tabla {{ $tabla }} fue generada con éxito</div>
@endif


<div class="card">
    <div class="card-header pt-5">
        <h5 class="fw-light float-start">Contenido de la tabla: <b>{{ $tabla }}</b></h5>
        <a href="{{ route('descargar_archivo',$id) }}" class="btn btn-sucess float-end descargar"><i class="lni lni-download"></i> Descargar</a>
    </div>
    <div class="card-body">

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

    </div>
</div>





@endsection