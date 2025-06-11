<div class="col-4">
    <div class="form-group mt-3">
    @if (!isset($selected) || $selected==="")
    <label for="{{ $id }}">{{ $label }}</label>
    <select class="wide form-control" id="{{ $id }}" name="{{ $name }}">
    @php
                    $options = array();
                    $min = date("Y")-28;
                    $max = date("Y")+3;
                    for($x=$min;$x<$max;$x++){
                        $array= ["id"=>$x,"option"=>$x];
                        array_push($options,$array);
                    }
    @endphp
     @foreach ($options as $array)
        <option value="{{ $array["id"] }}" {{  ((date("Y")==$array["option"])?"selected":"")}}>{{ $array["option"] }}</option>
    @endforeach
     </select>
             
    @endif
    @if (isset($selected) && $selected!="")

     <label for="{{ $id }}">{{ $label }}</label>
    <select class="wide form-control" id="{{ $id }}" name="{{ $name }}">
    @php
                    $options = array();
                    $min = date("Y")-28;
                    $max = date("Y")+3;
                    for($x=$min;$x<$max;$x++){
                        $array= ["id"=>$x,"option"=>$x];
                        array_push($options,$array);
                    }
    @endphp
    @foreach ($options as $array)
        <option value="{{ $array["id"] }}" {{  (($array["id"]==$selected)?"selected":"")}}>{{ $array["option"] }}</option>
    @endforeach
     </select>


    @endif


    </div>
</div>