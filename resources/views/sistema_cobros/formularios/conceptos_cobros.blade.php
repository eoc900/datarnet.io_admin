@if ($accion=="alta")

    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion">
        <x-lista-mensajes/>
        
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="conceptos_cobros"/>

            <x-campo-formulario label="Nombre de Concepto" id="nombre" name="nombre" type="text" placeholder="Inscripción" required="true"
                    parentClass="col-12"/>
            <x-campo-formulario label="Código de concepto" id="codigo_concepto" name="codigo_concepto" type="text" placeholder="INS" required="true"
                    parentClass="col-6"/>
            
            <div class="col-6 pt-3">
                <x-dropdown-formulario label="Categoría de cobro" id="categoria_cobro" :options="$categorias" value-key="id" option-key="categoria" simpleArray="false" name="categoria_cobro"/>
            </div>
            <div class="col-12 pt-3">
                <x-dropdown-formulario label="Enlazar a escuela" id="id_escuela" :options="$escuelas" value-key="id" option-key="codigo_escuela" simpleArray="false" name="id_escuela"/>
            </div>

            <div class="col-12 pt-3 dropdown_sistemas">
                {{-- El html se añade vía ajax. El name de este campo es: sistema_academico --}}
            </div>                
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
            <x-tag-formulario name="formulario" type="hidden" value="conceptos_cobros"/>

            <x-campo-formulario label="Nombre de Concepto" id="nombre" name="nombre" type="text" :value="$obj->nombre" placeholder="Inscripción" required="true"
                    parentClass="col-12"/>
            <x-campo-formulario label="Código de concepto" id="codigo_concepto" name="codigo_concepto" type="text" :value="$obj->codigo_concepto" placeholder="INS" required="true"
                    parentClass="col-6"/>
            <div class="col-6">
                <x-dropdown-formulario label="Categoría de cobro" id="id_categoria" :options="$categorias" value-key="id" option-key="categoria" simpleArray="false" name="categoria_cobro"  :selected="$obj->id_categoria"/>
            </div>
            
            {{-- Cuando se enlaza una escuela, debemos de mostrar un nuevo input que contenga solamente los sistemas académicos relacionados a la escuela --}}
            <div class="col-12 pt-3">
                <x-dropdown-formulario label="Enlazar a escuela" id="id_escuela" :options="$escuelas" value-key="id" option-key="codigo_escuela" simpleArray="false" name="id_escuela"  :selected="$obj->id_escuela"/>
            </div>
                 <div class="col-12 pt-3 dropdown_sistemas">
                {{-- El html se añade vía ajax. El name de este campo es: sistema_academico --}}
            </div>               
            <div class="col-6 pt-3">
                @php
                    $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
                @endphp
                <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo"  :selected="$obj->activo"/>
            </div>

             
            <x-boton nombre_boton="Crear Escuela" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </x-form-in-card>
@endif