@if ($accion=="alta")

    

    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion">
        <x-lista-mensajes/>
        @if(session('success'))
        <x-alert success="Se creó un nuevo sistema académico" />
        @endif
        @if(session('error'))
            <x-alert error="Lo sentimos hubo un error al tratar de insertar los datos." />
        @endif
        
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="sistema_academico"/>

            <x-campo-formulario label="Código Sistema Académico" id="codigo_sistema" name="codigo_sistema" type="text" placeholder="INGSistemasDigitales" required="true"
                    parentClass="col-12"/>
            
            <x-campo-formulario label="Nombre Oficial" id="nombre" name="nombre" type="text" placeholder="Ingeniería en Sistemas Digitales" required="true"
                    parentClass="col-12"/>
            
            <div class="col-12 pt-3">
                       <x-dropdown-formulario label="Nivel Académico" id="nivel_academico" :options="$niveles" value-key="id" option-key="option" simpleArray="true" name="nivel_academico" activo="activo"/>
            </div>

            <div class="col-12 pt-3">
                       <x-dropdown-formulario label="Escuela" id="codigo_escuela" :options="$escuelas" value-key="id" option-key="codigo_escuela" simpleArray="false" name="id_escuela" activo="activo"/>
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
        @if(session('success'))
        <x-alert success="Se creó un nuevo sistema académico" />
        @endif
        @if(session('error'))
            <x-alert error="Lo sentimos hubo un error al tratar de insertar los datos." />
        @endif
        
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="sistema_academico"/>

            <x-campo-formulario label="Código Sistema Académico" id="codigo_sistema" name="codigo_sistema" type="text" :value="$obj->codigo_sistema" placeholder="INGSistemasDigitales" required="true"
                    parentClass="col-12"/>
            
            <x-campo-formulario label="Nombre Oficial" id="nombre" name="nombre" type="text" :value="$obj->nombre" placeholder="Ingeniería en Sistemas Digitales" required="true"
                    parentClass="col-12"/>

            <div class="col-12 pt-3">
                       <x-dropdown-formulario label="Escuela" id="codigo_escuela" :options="$escuelas" value-key="id" option-key="codigo_escuela" simpleArray="false" name="id_escuela" :selected="$obj->id_escuela"/>
            </div>

            <div class="col-12 pt-3">
                       <x-dropdown-formulario label="Nivel Académico" id="nivel_academico" :options="$niveles" value-key="id" option-key="option" simpleArray="true" name="nivel_academico" activo="activo" :selected="$obj->nivel_academico"/>
            </div>

            <div class="col-6 pt-3">
             @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp

            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" :selected="$obj->activo"/>

            </div>

             
            <x-boton nombre_boton="Editar Sistema" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </x-form-in-card>
@endif