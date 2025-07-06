@if ($accion=="alta")

    @if(session('success'))
        <x-alert success="Se agregó un nuevo concepto de cobro" />
    @endif
    @if(session('error'))
        <x-alert error="Lo sentimos hubo un error al tratar de insertar los datos." />
    @endif

<x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion"  id="form">
    <x-lista-mensajes/>
  

        
    <div class="row">
     <x-tag-formulario name="formulario" type="hidden" value="cobros"/>
        <p class="tag-periodo"></p>
    <x-campo-formulario id="periodo" name="periodo" type="hidden" placeholder="Campo automático" required="true"
                    parentClass="col-12" />

    <div class="col-md-12 mt-4">
            <label for="{{ $idSelect2_2 }}">Cuenta del alumno</label>
            <x-select2 placeholder="Buscar cuenta del alumno" id="{{ $idSelect2_2 }}" name="id_cuenta" />
    </div>

    <div class="col-md-12 mt-4">
            <label for="{{ $idSelect2 }}">Selecciona el concepto</label>
            <x-select2 placeholder="Buscar concepto de cobro" id="{{ $idSelect2 }}" name="id_costo_concepto" />
    </div>
    <div class="col-12 pt-3">
        <x-dropdown-formulario label="Asignar estado de la ficha" id="estado" :options="$estadosCobro" value-key="id" option-key="option" simpleArray="true" name="estado"/>
    </div>
    <x-campo-formulario label="Fecha de inicio" id="fecha_inicio" name="fecha_inicio" type="datetime-local" required="true"
                    parentClass="col-6 mt-4" />

     <x-campo-formulario label="Fin de ficha" id="fecha_fin" name="fecha_fin" type="datetime-local" required="true"
                    parentClass="col-6 mt-4" />

<x-boton nombre_boton="Crear Escuela" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
  </div>         
</x-form-in-card>

@endif

@if ($accion=="edicion")
    
@endif