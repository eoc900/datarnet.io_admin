@if ($accion=="alta")

    @if(session('success'))
        <x-alert success="Se agregó una nueva cuenta" />
    @endif
    @if(session('error'))
        <x-alert error="Lo sentimos hubo un error al tratar de insertar los datos." />
    @endif

    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion">
        <x-lista-mensajes/>
        
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="cuentas"/>
            
            <x-select2 placeholder="Buscar alumno por nombre" id="{{ $idSelect2 }}" name="id_alumno" />

            <div class="col-12 pt-3">
                @php
                    $opciones = array(["id"=>"semanal","option"=>"Semanales"],
                    ["id"=>"quincenal","option"=>"Quincenales"],
                    ["id"=>"mensual","option"=>"Mensuales"])
                @endphp
                <x-dropdown-formulario label="Distribuir pagos" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="pagos" />
            </div>

            <x-dropdown-anio label="Selecciona el año" id="anio" name="anio" />
            <x-dropdown-cuatrimestre label="Selecciona el cuatrimestre" id="cuatri" name="cuatri" />

            
            

          
          

            <div class="col-12 pt-3">
                @php
                    $opciones = array(["id"=>0,"option"=>"Desactivada"],["id"=>1,"option"=>"Activa"])
                @endphp
                <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activa" />
            </div>

             
            <x-boton nombre_boton="Crear Escuela" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </x-form-in-card>
@endif

@if ($accion=="edicion")
    
@endif