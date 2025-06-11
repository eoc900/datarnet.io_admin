<hr>
    <div class="row">
        <div id="hilera_inputs">
            {{-- Este item se replica para agregar otra hilera y se hace con jquery --}}
            <div class="hilera_input">
                @foreach($campos as $index=>$campo)        
                        <div class="col-sm-4">
                            @if ($campo["type"]=="text")
                                @include("components.form_creator.ejemplos_inputs.text",["campo"=>$campo,"show"=>true,"tabla"=>$tabla_hija,"index"=>0])
                            @endif
                            @if ($campo["type"]=="date")
                                @include("components.form_creator.ejemplos_inputs.date",["campo"=>$campo,"show"=>true,"tabla"=>$tabla_hija,"index"=>0])
                            @endif
                            @if ($campo["type"]=="datetime")
                                @include("components.form_creator.ejemplos_inputs.datetime",["campo"=>$campo,"show"=>true,"tabla"=>$tabla_hija,"index"=>0])
                            @endif
                            @if ($campo["type"]=="select2")
                                @include("components.form_creator.ejemplos_inputs.select2",["campo"=>$campo,"show"=>true,"tabla"=>$tabla_hija,"index"=>0])
                            @endif
                            @if ($campo["type"]=="dropdown")
                                @include("components.form_creator.ejemplos_inputs.dropdown",["campo"=>$campo,"show"=>true,"tabla"=>$tabla_hija,"index"=>0])
                            @endif
                            @if ($campo["type"]=="radio")
                                @include("components.form_creator.ejemplos_inputs.radio",["campo"=>$campo,"show"=>true,"tabla"=>$tabla_hija,"index"=>0])
                            @endif
                            @if ($campo["type"]=="email")
                                @include("components.form_creator.ejemplos_inputs.email",["campo"=>$campo,"show"=>true,"tabla"=>$tabla_hija,"index"=>0])
                            @endif
                            @if ($campo["type"]=="file")
                                @include("components.form_creator.ejemplos_inputs.file",["campo"=>$campo,"show"=>true,"tabla"=>$tabla_hija,"index"=>0])
                            @endif
                            @if ($campo["type"]=="checkbox")
                                @include("components.form_creator.ejemplos_inputs.checkbox",["campo"=>$campo,"show"=>true,"tabla"=>$tabla_hija,"index"=>0])
                            @endif
                            @if ($campo["type"]=="hidden")
                                @include("components.form_creator.ejemplos_inputs.hidden",["campo"=>$campo,"show"=>true,"tabla"=>$tabla_hija,"index"=>0])
                            @endif
                        </div>
            @endforeach
                    @php
                         $nameAttr = "input[{$input["tabla_hija"]}][0][{$input['llave_foranea']}]";
                    @endphp
                    <input type="hidden" value="{{ $input["llave_foranea"]??'' }}" name="{{ $nameAttr }}" class="llave_foranea">
                <div class="text-end mt-2">
                    <button type="button" class="btn btn-danger btn-sm eliminar_hilera">Eliminar</button>
                </div>
            </div>
        </div>
        <div class="col-sm-4 pt-4"><button type="button" class="btn btn-primary agregar_registro_multiple">agregar</button></td></div>

    </div>
    
<hr>
