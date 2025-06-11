@if ($accion=="alta")

    @if(session('success'))
        <x-alert success="Se agregaron los permisos" />
    @endif
    @if(session('error'))
        <x-alert error="Lo sentimos hubo un error al tratar de insertar los datos." />
    @endif

    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion">
        <x-lista-mensajes/>

       
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="{{ $formulario }}"/>

            <div class="col-12 pt-3">
                <x-dropdown-formulario label="Roles disponibles" id="rol" :options="$roles" value-key="name" option-key="name" simpleArray="false" name="rol"/>
            </div>
            <div class="col-12 pt-3">
                @php
                    $x = 0;
                @endphp
                @foreach ($permissions as $permiso)
                    <x-check-box :id="$x" name="permiso[]" :value="$permiso->name" :label="$permiso->name" />
                   @php
                       $x++;
                   @endphp
                @endforeach
            </div>

            <x-boton nombre_boton="Crear Rol" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>

        </div>
    </x-form-in-card>
@endif

@if ($accion=="edicion")
    
@endif