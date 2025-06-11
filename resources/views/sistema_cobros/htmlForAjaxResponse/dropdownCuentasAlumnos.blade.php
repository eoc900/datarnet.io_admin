@if(count($cuentas)>0)
<label for="sistema_academico" class="mt-3">Cuentas del alumno</label>
<select name="cuenta" id="cuenta" class="form-control">
        @foreach ($cuentas as $cuenta)
            <option value="{{ $cuenta->id }}" {{ ($cuentas[count($cuentas)-1]==$cuenta)?"selected":"" }}>
                Periodo: {{ $cuenta->cuatrimestre }}| Cargos totales: ${{ $cuenta->total_cargos}} | Pagos totales:  ${{ $cuenta->total_pagos}}
            </option>
        @endforeach
</select>
@else
<div class="alert alert-warning mt-5">No tienes cuentas abiertas para este alumno. Crea una cuenta primero, para poder registrar el pago del alumno.</div>
@endif