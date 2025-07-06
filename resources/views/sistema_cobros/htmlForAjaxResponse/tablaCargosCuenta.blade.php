@if(isset($cargos))
<table class="table align-middle mt-5">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Concepto</th>
            <th>F. Inicio</th>
            <th>Vence</th>
            <th>Monto</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cargos as $cargo)
        <tr>
            <td>{{ $cargo->num_cargo }}</td>
            <td>{{ $cargo->codigo_concepto }}</td>
            <td>{{ $cargo->fecha_inicio }}</td>
            <td>{{ $cargo->fecha_finaliza }}</td>
            <td>{{ $cargo->monto_real }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endif