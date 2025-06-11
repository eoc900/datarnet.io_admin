@if(count($sistemas)>0)
<label for="sistema_academico text-danger">Aplicable para <b>colegiaturas solamente:</b></label>
<select name="sistema_academico" id="sistema_academico" class="form-control" data-seleccionado="{{ $seleccionado }}">
        @foreach ($sistemas as $sistema)
            <option value="{{ $sistema->id }}" {{ ($seleccionado==$sistema->id)?"selected":""; }}>
                {{ $sistema->nombre }} ({{ $sistema->codigo_sistema }})
            </option>
        @endforeach
</select>
@else
<div class="alert alert-warning">No tienes sistemas enlazados a esta escuela</div>
@endif