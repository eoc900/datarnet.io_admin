@if(isset($pagos))

@php
    $x =0;
@endphp
<table class="table align-middle mt-5">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Tipo de pago</th>
            <th>Monto</th>
            <th>Fecha pago</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pagos as $pago)
        <tr>
            <td>{{ $x }}</td>
            <td>{{ $pago->tipo_pago }}</td>
            <td>{{ $pago->monto }}</td>
            <td>{{ $pago->created_at }}</td>
        </tr>
       @php
           $x++;
       @endphp
        @endforeach
    </tbody>
</table>

@endif