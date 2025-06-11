<div class="row configuracion-input shadow border border-light py-5 px-3 mt-3 subcampo">
<button type="button" class="remove-conf-input btn btn-danger"><i class="lni lni-close"></i></button>
<input type="hidden" name="input[]" value="multi-item">
<h5 class="text-dark">Campos múltiples (multi-item)</h5>

<div class="row">

    <div class="col-sm-6">
        <label for="" class="form-label">Descripción de subformulario multi-item</label>
        <input type="text" name="inputs[{{$i}}][descripcion_subformulario]" placeholder="Conceptos pagados" class="form-control">
    </div>
    <div class="col-sm-6">
        <label for="" class="form-label">Nombre tabla hija</label>
        <input type="text" name="inputs[{{$i}}][tabla_hija]" value="" class="form-control">
    </div>

    @php
        $input_types = [
        ["value"=>"dropdown","option"=>"Desplegable con opciones (referenciable a tablas de base de datos)"],
        ["value"=>"select2","option"=>"Campo de búsqueda (referenciable a tablas de base de datos)"],
        ["value"=>"checkbox","option"=>"Campo palomeable"],
        ["value"=>"text","option"=>"Campo de texto abierto"],
        ["value"=>"radio","option"=>"Botones circulares"],
        ["value"=>"datetime","option"=>"Fecha y hora"],
        ["value"=>"date","option"=>"Fecha"],
        ["value"=>"email","option"=>"Correo electrónico"],
        ["value"=>"file","option"=>"Archivo"],
        ["value"=>"hidden","option"=>"Campo Escondido"]
    ];
    @endphp

    <div class="col-12 mt-5">
    <div class="input-group">
         <button type="button" class="btn btn-outline-dark">Campos disponibles</button>
        <select name="subcampo" class="input-type form-control opciones-subcampo">
            @foreach ($input_types as $input)
                <option value="{{ $input["value"] }}">{{ $input["option"] }}</option>
            @endforeach
        </select>
        <button type="button" class="btn btn-outline-primary agregar-subcampo" data-index="{{$i}}">Agregar campo hijo</button>
    </div>
    </div>

</div>
    

    
 
   

    <!-- Contenedor de subcampos -->
    <div class="campos-hijos mt-4" data-index="{{$i}}">
        <!-- Aquí se insertan dinámicamente los campos hijos -->
    </div>

</div>
