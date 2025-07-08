@if(!empty($registros) && count($registros) > 0)

<div class="col-md-{{ $seccion["col"] ?? 12 }}">
    @if(!empty($seccion['titulo']))
        <h5 class="mb-3">{{ $seccion['titulo'] }}</h5>
    @endif

    <div class="table-responsive scroll-x">
        <table class="table table-striped table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    @foreach(array_keys((array) $registros[0]) as $columna)
                        <th>{{ Str::headline(str_replace('_', ' ', $columna)) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($registros as $fila)
                    <tr>
                        @foreach((array) $fila as $valor)
                            <td>
                                @php
                                    $valorStr = is_numeric($valor) ? number_format($valor, 2) : $valor;
                                    // Formato de fecha
                                    if (preg_match('/^\d{4}-\d{2}-\d{2}/', $valor)) {
                                        $valorStr = \Carbon\Carbon::parse($valor)->format('d M Y');
                                    }
                                @endphp
                                {{ $valorStr }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
    <div class="alert alert-info">
        No hay resultados para mostrar en esta sección.
    </div>
@endif
