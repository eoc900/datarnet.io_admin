<div class="input-group where-logic mt-2">
@php
    $joins = [" ","and","or"];
@endphp

<select name="where_logic[]" class="join form-control">
    @foreach ($joins as $join)
        <option value="{{ $join }}" {{ ($selected==$join)?"selected":"" }}>{{ $join }}</option>
    @endforeach
</select>
<button type="button" class="btn btn-danger"><i class="lni lni-close"></i></button>
</div>