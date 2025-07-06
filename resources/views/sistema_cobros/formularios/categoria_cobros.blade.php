@if ($accion=="alta")

    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion">
        <x-lista-mensajes/>
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="categoria_cobros"/>

            <x-campo-formulario label="Nombre de Categoría" id="categoria" name="categoria" type="text" placeholder="Categoría" required="true" parentClass="col-12"/>
            <div class="col-6 pt-3">
                @php
                    $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
                @endphp
                <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" />
            </div>

             
            <x-boton nombre_boton="Crear Escuela" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </x-form-in-card>
@endif

@if ($accion=="edicion")
     <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion" :obj="$obj">
        <x-lista-mensajes/>
        
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="categoria_cobros"/>

            <x-campo-formulario label="Nombre de Categoría" id="categoria" name="categoria" type="text" :value="$obj->categoria" placeholder="Categoría" required="true" parentClass="col-12"/>
                <div class="col-6 pt-3">
                @php
                    $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
                @endphp
                <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo"  :selected="$obj->activo"/>
                </div>

             
            <x-boton nombre_boton="Crear Categoría" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </x-form-in-card>
@endif