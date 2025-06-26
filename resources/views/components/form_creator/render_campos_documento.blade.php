@if (isset($documento))
            {{-- USO: ITERACIÓN Para poner cada componente de formulario --}}
            @foreach ($documento["inputs"] as $index=>$input)
                {{-- <div class="col-sm-6 mt-3"> --}}
                @if ($input["type"]=="text")
                    @include("components.form_creator.text_config",["input"=>$input,"index"=>$index])
                @endif
                @if ($input["type"]=="dropdown")
                    @include("components.form_creator.dropdown_config",["input"=>$input,"i"=>$index,"tablas"=>$tablas])
                @endif
                @if ($input["type"]=="date")
                    @include("components.form_creator.date_config",["input"=>$input,"i"=>$index])
                @endif
                @if ($input["type"]=="time")
                    @include("components.form_creator.time_config",["input"=>$input,"i"=>$index])
                @endif
                @if ($input["type"]=="datetime")
                    @include("components.form_creator.datetime_config",["input"=>$input,"i"=>$index])
                @endif
                @if ($input["type"]=="select2")
                    @include("components.form_creator.select2_config",["input"=>$input,"i"=>$index,"tablas"=>$tablas])
                @endif
                @if ($input["type"]=="radio")
                    @include("components.form_creator.radio_config",["input"=>$input,"i"=>$index])
                @endif
                @if ($input["type"]=="email")
                    @include("components.form_creator.email_config",$input)
                @endif 
                @if ($input["type"]=="file")
                    @include("components.form_creator.file_config",["input"=>$input,"i"=>$index])
                @endif
                @if ($input["type"]=="hidden")
                    @include("components.form_creator.hidden_input_config",["input"=>$input,"i"=>$index])
                @endif
                @if ($input["type"]=="multi-item")
                    @include("components.form_creator.modales.multi_item_config",["input"=>$input,"i"=>$index])
                @endif  
                {{-- </div> --}}
            @endforeach
             {{-- USO:  Para poner cada componente de formulario --}}
@endif