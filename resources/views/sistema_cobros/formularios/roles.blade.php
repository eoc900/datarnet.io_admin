@if ($accion=="alta")

    @if(session('success'))
        <x-alert success="Se creó un nuevo plantel" />
    @endif
    @if(session('error'))
        <x-alert error="Lo sentimos hubo un error al tratar de insertar los datos." />
    @endif

    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion">
        <x-lista-mensajes/>

       
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="{{ $formulario }}"/>

            <x-campo-formulario label="Nombre del rol" id="rol" name="rol" type="text" placeholder="ejemplo: Promotor" required="true" parentClass="col-12"/>
            <x-boton nombre_boton="Crear Rol" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>

        </div>
    </x-form-in-card>
@endif

@if ($accion=="edicion")
    
@endif