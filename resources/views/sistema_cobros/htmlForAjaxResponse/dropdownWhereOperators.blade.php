<div class="input-group where-group mt-2">
@php
    $joins = ["=",">","<","like","between"];
@endphp
<select name="operador_where[]" class="form-control where_operator">
    @foreach ($joins as $join)
        <option value="{{ $join }}">{{ $join }}</option>
    @endforeach
</select>
<button type="button" class="btn btn-danger"><i class="lni lni-close"></i></button>
</div>