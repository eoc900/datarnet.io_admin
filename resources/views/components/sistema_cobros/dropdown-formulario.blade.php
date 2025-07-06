@if($simpleArray=="false" && !$extras)
    <div class="form-group mt-3">
    <label for="{{ $id }}">{{ $label }}</label>
    <select class="wide form-control mt-2" id="{{ $id }}" name="{{ $name }}">
        @foreach ($options as $clases=>$array)
            <option value="{{ $array->{$valueKey}  }}" {{ ($selected==$array->{$valueKey})?"selected":"" }}>{{ $array->{$optionKey} }} {{ ($activo)?"(Activo)":"" }}{{ $slot }}</option>
        @endforeach
    </select>
    </div>
@elseif ($simpleArray=="false" && $extras=="true")
<div class="form-group mt-3">
<label for="{{ $id }}">{{ $label }}</label>
<select class="wide form-control mt-2" id="{{ $id }}" name="{{ $name }}">
   {{$slot}}
</select>
</div>




@else
<div class="form-group mt-3">
<label for="{{ $id }}">{{ $label }}</label>
<select class="wide form-control mt-2" id="{{ $id }}" name="{{ $name }}">
    @foreach ($options as $array)
        <option value="{{ $array[$valueKey] }}" {{ ($selected==$array[$valueKey])?"selected":"" }}>{{ $array[$optionKey] }} </option>
    @endforeach
</select>
</div>
@endif