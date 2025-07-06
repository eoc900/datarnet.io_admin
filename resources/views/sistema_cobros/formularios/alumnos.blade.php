@if ($accion=="alta")

    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion">
        <x-lista-mensajes/>
        
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="alumnos"/>

            <x-campo-formulario label="Nombre" id="nombre" name="nombre" type="text" placeholder="Ejemplo: Ulises" required="true"
                    parentClass="col-12"/>
            <x-campo-formulario label="Apellido Paterno" id="apellido_paterno" name="apellido_paterno" type="text" placeholder="Apellido Paterno" required="true"
            parentClass="col-12"/>
            <x-campo-formulario label="Apellido Materno" id="apellido_materno" name="apellido_materno" type="text" placeholder="Apellido Materno" required="true"
            parentClass="col-12"/>
             <x-campo-formulario label="Matrícula" id="matricula" name="matricula" type="text" placeholder="Matrícula del alumno"
            parentClass="col-12"/>
            <div class="col-12 pt-3">
                <x-dropdown-formulario label="Sistema Académico" id="id_sistema" :options="$sistemas_academicos" value-key="id" option-key="codigo_sistema" simpleArray="false" name="id_sistema"/>
            </div>

            <div class="col-6 pt-3">
             @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp

            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" />

            </div>

             
            <x-boton nombre_boton="Crear Alumno" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </x-form-in-card>
@endif

@if ($accion=="edicion")
    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion" :obj="$obj">
        <x-lista-mensajes/>
        
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="alumnos" />

            <x-campo-formulario label="Nombre" id="nombre" name="nombre" type="text" :value="$obj->nombre" placeholder="Ejemplo: Ulises" required="true"
            parentClass="col-12"/>
            <x-campo-formulario label="Apellido Paterno" id="apellido_paterno" name="apellido_paterno" type="text" :value="$obj->apellido_paterno" placeholder="Apellido Paterno" required="true"
            parentClass="col-12"/>
            <x-campo-formulario label="Apellido Materno" id="apellido_materno" name="apellido_materno" type="text" :value="$obj->apellido_materno" placeholder="Apellido Materno" required="true"
            parentClass="col-12"/>
            <x-campo-formulario label="Matrícula" id="matricula" name="matricula" type="text" :value="$obj->matricula" placeholder="Matrícula del alumno"
            parentClass="col-12"/>
            

            <div class="col-12 pt-3">
                <x-dropdown-formulario label="Sistema Académico" id="id_sistema" :options="$sistemas" value-key="id" option-key="codigo_sistema" simpleArray="false" name="id_sistema" :selected="$obj->id_sistema_academico"/>
            </div>

            <div class="col-6 pt-3">
             @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp

            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" :selected="$obj->activo"/>

            </div>

             
            <x-boton nombre_boton="Editar alumno" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </x-form-in-card>
@endif