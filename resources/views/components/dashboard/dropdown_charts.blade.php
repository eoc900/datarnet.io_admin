@php
    $charts = [["value"=>"linechart","opcion"=>"Lineal"],
    ["value"=>"barchart","opcion"=>"Barras"],
    ["value"=>"piechart","opcion"=>"Pie"],
    ["value"=>"areachart","opcion"=>"Area"]];
@endphp
<div class="input-group">
<select name="tipo_grafica[]" id="" class="form-control">
    @foreach ($charts as $chart)
        <option value="{{ $chart["value"] }}">{{ $chart["opcion"] }}</option>
    @endforeach 
</select>
 <button type="button" class="btn btn-success add-graph"><i class="lni lni-select"></i></button>
 </div>