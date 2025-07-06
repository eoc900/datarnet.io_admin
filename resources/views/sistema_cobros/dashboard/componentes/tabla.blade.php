
<div class="container mt-5">

        @if(isset($mostrar_tabla) && $mostrar_tabla==1)
        <div class="card">
        <div class="card-body">
        <h5 class="mb-4">{{ $nombre_reporte }}</h5>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        @if ($resultados->count() > 0)
                            <!-- Convertir el primer resultado a array y obtener las claves -->
                            @foreach (array_keys((array) $resultados->first()) as $columna)
                                <th>{{ ucfirst($columna) }}</th>
                            @endforeach
                        @else
                            <th>No hay datos</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($resultados->count() > 0)
                        <!-- Recorrer los resultados -->
                        @foreach ($resultados as $fila)
                            <tr>
                                <!-- Convertir cada fila a array y recorrer los valores -->
                                @foreach ((array) $fila as $valor)
                                    <td>{{ $valor }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="100%" class="text-center">No hay registros para mostrar.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        </div>
        </div>
        @endif
    </div>




