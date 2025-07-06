<div class="col-4">
    <div class="form-group mt-3">
    @if (!isset($selected))
    <label for="{{ $id }}">{{ $label }}</label>
    <select class="wide form-control" id="{{ $id }}" name="{{ $name }}">
    @php
                    $options = array(["id"=>01,"option"=>"Enero-Abril"],["id"=>02,"option"=>"Mayo-Agosto"],["id"=>03,"option"=>"Sep-Dic"]);    
    @endphp
    @foreach ($options as $array)
        <option value="{{ $array["id"] }}" {{  ((date("Y")==$array["option"])?"selected":"")}}>{{ $array["option"] }}</option>
    @endforeach
    </select>
    @endif

    @if (isset($selected))
    <label for="{{ $id }}">{{ $label }}</label>
    <select class="wide form-control" id="{{ $id }}" name="{{ $name }}">
    @php
                    $options = array(["id"=>01,"option"=>"Enero-Abril"],["id"=>02,"option"=>"Mayo-Agosto"],["id"=>03,"option"=>"Sep-Dic"]);    
    @endphp
    @foreach ($options as $array)
        <option value="{{ $array["id"] }}" {{  (($array["id"]==$selected)?"selected":"")}}>{{ $array["option"] }}</option>
    @endforeach
    </select>
    @endif
    </div>
</div>