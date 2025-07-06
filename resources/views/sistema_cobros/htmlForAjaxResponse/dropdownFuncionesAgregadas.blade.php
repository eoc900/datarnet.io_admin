<div class="input-group funcion-agregada mt-2">
@php
    $joins = ["SUM","AVG","COUNT","MAX","MIN"];
@endphp
    <select name="funcion[]" class="join form-control btn btn-primary">
    @foreach ($joins as $join)
        <option value="{{ $join }}">{{ $join }}</option>
    @endforeach
    </select>
    <input type="text" name="columna_funcion[]" value="{{ $columna??'No se encontró la columna :(' }}" class="form-control" readonly>
    <input type="text" name="columna_as[]" class="form-control" placeholder="Ejemplo: conteo_alumnos" required>
    <button type="button" class="btn btn-danger"><i class="lni lni-close"></i></button>

</div>