
@if (isset($cargos) && $cargos->count()>0)
<ul>
@foreach($cargos as $pago)
    <li>
        <label>
            <input type="checkbox" name="pagos[]" value="{{ $pago->id }}">
            {{ $pago->codigo_concepto}}  #{{ $pago->num_cargo }} - Monto: {{ $pago->monto_real }} - Fecha límite: {{ $pago->fecha_finaliza }}
        </label>
    </li>
@endforeach
</ul>
@else

<div class="alert alert-danger">Aún no hay pagos pendientes registrados en esta cuenta</div>

@endif

