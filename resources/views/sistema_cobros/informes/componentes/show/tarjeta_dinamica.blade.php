@if(!empty($registros) && count($registros) > 0)
    @php
        $columnas = array_keys((array) $registros[0]);
    @endphp

<div class="col-md-{{ $col }}">
    @if(count($columnas) === 2)
        <div class="row">
            @foreach($registros as $fila)
                @php
                    $fila = (array) $fila;
                    $titulo = $fila[$columnas[0]];
                    $valor = $fila[$columnas[1]];
                @endphp

                <div class="col-sm-4 mb-4 seccion">
                    <h5>{{ $tarjeta_titulo??'' }}</h5>
                    <div class="card rounded shadow border p-3 h-auto">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-3">
                                <i class="lni lni-bar-chart fs-3"></i>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $titulo }}</h6>
                                </div>
                                <div class="">
                                    <h5 class="mb-0">{{ $valor }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">
            Este componente de tarjetas sólo puede usarse cuando el resultado tiene exactamente 2 columnas.
            Actualmente se detectaron <strong>{{ count($columnas) }}</strong> columnas:
            <em>{{ implode(', ', $columnas) }}</em>
        </div>
    @endif
    </div>
@else
    <div class="alert alert-info">
        No hay resultados para mostrar.
    </div>
@endif
