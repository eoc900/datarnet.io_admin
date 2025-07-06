<div class="input-group join-group mt-2">
@php
    $joins = ["leftJoin","join"];
@endphp

<select name="join[]" class="join form-control">
    @foreach ($joins as $join)
        <option value="{{ $join }}">{{ $join }}</option>
    @endforeach
</select>
<button type="button" class="btn btn-danger"><i class="lni lni-close"></i></button>
</div>