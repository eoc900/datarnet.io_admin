@if ($accion=="alta")

    @if(session('success'))
        <x-alert success="Se creó un nuevo permiso" />
    @endif
    @if(session('error'))
        <x-alert error="Lo sentimos hubo un error al tratar de insertar los datos." />
    @endif

    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion">
        <x-lista-mensajes/>

       
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="{{ $formulario }}"/>

            <x-campo-formulario label="Nombre del permiso" id="permiso" name="permiso" type="text" placeholder="ejemplo: Ver lista alumnos, editar eventos, agregar eventos" required="true" parentClass="col-12"/>
            <x-boton nombre_boton="Crear Permiso" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>

        </div>
    </x-form-in-card>
@endif

@if ($accion=="edicion")
    
@endif