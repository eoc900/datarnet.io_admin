
<table class="table table-bordered table-hover table-striped table-sm">
    <thead class="table-dark">
        <tr>
            @foreach($columnas as $col)
                <th>{{ ucfirst(str_replace('_', ' ', $col)) }}</th>
            @endforeach
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($resultados as $fila)
            <tr>
                @foreach($columnas as $col)
                    <td>{{ $fila->$col }}</td>
                @endforeach
                <td>
                    <a href="{{ route('editar.registro', ['tabla' => $tabla, 'id' => $fila->id]) }}" class="btn btn-primary btn-sm">
                        Editar
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($columnas) }}" class="text-center">No se encontraron resultados.</td>
            </tr>
        @endforelse
    </tbody>
</table>