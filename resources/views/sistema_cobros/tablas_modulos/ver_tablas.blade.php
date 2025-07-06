@extends('sistema_cobros.tablas_modulos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')  


<div class="card">
    <div class="card-header pt-4">
      <h5 class="float-start"> {{ $tabla }}</h5> 
        @include('components.form_creator.componentes_busqueda.buscar_una_columna',[
            "clase_contenedor"=>".tabla_resultados",
            "columnas"=>$columnas,
            "tabla"=>$tabla
            ])
        @if(!empty($datos) && $datos->isNotEmpty())
        <a href="{{ route('descargar_tabla',$tabla) }}" class="btn btn-sucess float-end descargar"><i class="lni lni-download"></i> Descargar</a>
        @endif
    </div>
    <div class="card-body">
        @if(!empty($datos) && $datos->isNotEmpty())
        <div class="tabla_resultados">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    
                        @foreach(array_keys((array) $datos->first()) as $columna)
                            <th>{{ ucfirst(str_replace('_', ' ', $columna)) }}</th>
                        @endforeach
                        <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $fila)
                    <tr>
                        @foreach((array) $fila as $valor)
                            <td>{{ $valor }}</td>
                        @endforeach
                         <td>
                            <a href="{{ route('editar.registro', ['tabla' => $tabla, 'id' => $fila->id]) }}" class="btn btn-primary btn-sm">
                                Editar
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
            <div class="alert alert-danger">No hay datos disponibles</div>
            
        @endif
        </div>
    </div>
</div>
@endsection