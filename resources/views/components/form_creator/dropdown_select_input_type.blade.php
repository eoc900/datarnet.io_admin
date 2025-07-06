<div class="input-segment">
    {{-- NOTA[input-segment]: input segment es importante porque agrupa la configuracion del input de formulario y el tipo de input --}}
    <div class="input-group input_types mt-2">
        @php
            $input_types = [
            ["value"=>"dropdown","option"=>"Desplegable con opciones (referenciable a tablas de base de datos)"],
            ["value"=>"select2","option"=>"Campo de búsqueda (referenciable a tablas de base de datos)"],
            ["value"=>"checkbox","option"=>"Campo palomeable"],
            ["value"=>"text","option"=>"Campo de texto abierto"],
            ["value"=>"radio","option"=>"Botones circulares"],
            ["value"=>"datetime","option"=>"Fecha y hora"],
            ["value"=>"time","option"=>"Tiempo en horas"],
            ["value"=>"date","option"=>"Fecha"],
            ["value"=>"email","option"=>"Correo electrónico"],
            ["value"=>"file","option"=>"Archivo"],
            ["value"=>"hidden","option"=>"Campo Escondido"],
            ["value"=>"multi-item","option"=>"Campos Multiples Dinámicos"]
        ];
        @endphp
        <button type="button" class="btn btn-outline-dark">Campos disponibles</button>
        <select name="input_type[]" class="input-type form-control">
            @foreach ($input_types as $input)
                <option value="{{ $input["value"] }}">{{ $input["option"] }}</option>
            @endforeach
        </select>
        <button type="button" class="btn btn-primary agregar-campo"><i class="lni lni-circle-plus"></i> Agregar campo</button>
    </div>
    @if (!isset($formulario_enlazado))
        <div class="campos-configuracion">
        <p class="text-primary text-center"><i class="fadeIn animated bx bx-slider"></i></p>
        <p class="text-primary text-center">Selecciona el tipo de campo.</p>
        {{-- NOTA[campos-configuracion, agregar-cammpo]: al momento de hacer click en agregar campo se incrusta la configuración especifica al tipo de campo --}}
        </div>
    @endif
</div>
