@foreach($paresDeTablas as $index => $par)
<div class="row align-items-center mb-3 join-block border shadow pb-5 pt-5">
    <div class="col-md-12">
        <label>Tabla: {{ $par['a'] }}</label>
         <select name="joins[{{ $index }}][tabla_a]" class="form-control tabla_a_selector" data-index="{{ $index }}">
            @foreach($tablasSeleccionadas as $tabla)
                <option value="{{ $tabla }}" {{ $tabla === $par['a'] ? 'selected' : '' }}>{{ $tabla }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <label>Columna de {{ $par['a'] }}</label>
        <div class="drop-columna-a border rounded p-2" data-index="{{ $index }}" data-tabla="{{ $par['a'] }}"></div>
    </div>

    <div class="col-md-12">
        <label>Tabla: {{ $par['b'] }}</label>
        <select name="joins[{{ $index }}][tabla_b]" class="form-control tabla_b_selector" data-index="{{ $index }}">
            @foreach($tablasSeleccionadas as $tabla)
                <option value="{{ $tabla }}" {{ $tabla === $par['b'] ? 'selected' : '' }}>{{ $tabla }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12">
        <label>Columna de {{ $par['b'] }}</label>
        <div class="drop-columna-b border rounded p-2" data-index="{{ $index }}" data-tabla="{{ $par['b'] }}"></div>
    </div>
</div>
@endforeach

