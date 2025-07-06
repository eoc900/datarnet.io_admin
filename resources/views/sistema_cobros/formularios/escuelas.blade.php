@if ($accion=="alta")

    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion">
        <x-lista-mensajes/>

       
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="escuela"/>

            <x-campo-formulario label="Código Escuela" id="codigo_escuela" name="codigo_escuela" type="text" placeholder="ejemplo: CECe" required="true"
                    parentClass="col-12"/>
            
            <x-campo-formulario label="Nombre Oficial" id="nombre" name="nombre" type="text" placeholder="Ejemplo: Centro de Estudios de Celaya" required="true"
                    parentClass="col-12"/>

            <x-campo-formulario label="Calle" id="calle" name="calle" type="text" placeholder="Calle" required="true"
                    parentClass="col-12"/>

            <x-campo-formulario label="Número Exterior" id="num_exterior" name="num_exterior" type="text" placeholder="Núm. Exterior" required="true"
            parentClass="col-6"/>

                <x-campo-formulario label="Número Interior" id="num_interior" name="num_interior" type="text" placeholder="Núm. Interior"
            parentClass="col-6"/>

            <x-campo-formulario label="Colonia" id="colonia" name="colonia" type="text" placeholder="Colonia" required="true"
            parentClass="col-8"/>

            <x-campo-formulario label="Código Postal" id="codigo_postal" name="codigo_postal" type="text" placeholder="Código Postal" required="true"
            parentClass="col-4"/>

            <x-campo-formulario label="Ciudad" id="ciudad" name="ciudad" type="text" placeholder="Ciudad" required="true"
            parentClass="col-6"/>

            <x-campo-formulario label="Estado" id="estado" name="estado" type="text" placeholder="Estado" required="true"
            parentClass="col-6"/>

            <div class="mb-3 mt-3">
                <label class="form-label">Escoge el logo de la escuela:</label>
                <input type="file" class="form-control" name="imagen_logo">
            </div>


            <div class="col-6 pt-3">
             @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp

            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo"/>

            </div>

             
            <x-boton nombre_boton="Crear Escuela" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </x-form-in-card>
@endif

@if ($accion=="edicion")
     <form action="{{ route('escuelas.update', $escuela->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <x-lista-mensajes/>
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="escuela"/>

            <x-campo-formulario label="Código Escuela" id="codigo_escuela" name="codigo_escuela" type="text" :value="$obj->codigo_escuela" placeholder="ejemplo: CECe" required="true"
                    parentClass="col-12"/>
            
            <x-campo-formulario label="Nombre Oficial" id="nombre" name="nombre" type="text" :value="$obj->nombre" placeholder="Ejemplo: Centro de Estudios de Celaya" required="true"
                    parentClass="col-12"/>

            <x-campo-formulario label="Calle" id="calle" name="calle" type="text" :value="$obj->calle" placeholder="Calle" required="true"
                    parentClass="col-12"/>

            <x-campo-formulario label="Número Exterior" id="num_exterior" name="num_exterior" type="text" :value="$obj->num_exterior" placeholder="Núm. Exterior" required="true"
            parentClass="col-6"/>

                <x-campo-formulario label="Número Interior" id="num_interior" name="num_interior" type="text" :value="$obj->num_interior" placeholder="Núm. Interior"
            parentClass="col-6"/>

            <x-campo-formulario label="Colonia" id="colonia" name="colonia" type="text" :value="$obj->colonia" placeholder="Colonia" required="true"
            parentClass="col-8"/>

            <x-campo-formulario label="Código Postal" id="codigo_postal" name="codigo_postal" type="text" :value="$obj->codigo_postal" placeholder="Código Postal" required="true"
            parentClass="col-4"/>

            <x-campo-formulario label="Ciudad" id="ciudad" name="ciudad" type="text" :value="$obj->ciudad" placeholder="Ciudad" required="true"
            parentClass="col-6"/>

            <x-campo-formulario label="Estado" id="estado" name="estado" type="text" :value="$obj->estado" placeholder="Estado" required="true"
            parentClass="col-6"/>


            <div class="col-6 pt-3">
                @php
                    $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
                @endphp
                <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" :selected="$obj->activo"/>
            </div>


            
            <div class="mb-3 mt-3">
                    @if ($obj->imagen_logo)
                    <img src="{{ asset('storage/logos/' . $obj->imagen_logo); }}" alt="Logo anterior" class="img-fluid mt-2" width="200"><br>
                    @endif
                    <label class="form-label mt-5">Escoge otro logo de escuela <span class="text-danger">(Opcional)</span></label>
                    <input type="file" class="form-control" name="imagen_logo">
            </div>

             
            <x-boton nombre_boton="Crear Escuela" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </form>
@endif