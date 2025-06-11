@if(count($costos)>0)
<label for="costos text-danger">Selecciona el cargo</label>
<select name="id_costo" id="sistema_academico" class="form-control">
        @foreach ($costos as $costo)
            <option value="{{ $costo->id_costo }}">
                {{ $costo->nombre }} | Periodo: {{ $costo->periodo }} | Costo: ${{ number_format($costo->costo,2); }}
            </option>
        @endforeach
</select>
@else
<div class="alert alert-warning">No tienes costos asociados al sistema o al periodo en el que estudia este alumno.</div>
@endif