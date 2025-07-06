@if(!empty($registros) && count($registros) > 0)

<div class="col-md-{{ $seccion["col"]  }}">
    <div class="table-responsive scroll-x">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    @foreach(array_keys((array) $registros[0]) as $columna)
                        <th>{{ ucfirst(str_replace('_', ' ', $columna)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($registros as $fila)
                    <tr>
                        @foreach((array) $fila as $valor)
                            <td>{{ $valor }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
    <div class="alert alert-info">
        No hay resultados para mostrar.
    </div>
@endif
