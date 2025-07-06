@if ($accion=="alta")

    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion"  id="costo_concepto">
        <x-lista-mensajes/>
        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="{{ $formulario }}"/>
            <x-select2 placeholder="Buscar concepto por código o nombre" id="{{ $idSelect2 }}" name="id_concepto" />

 

            
              
            <x-dropdown-anio label="Selecciona el año" id="anio" name="anio" />
            <x-dropdown-cuatrimestre label="Selecciona el cuatrimestre" id="cuatri" name="cuatri" />

            <div class="col-6 pt-3">
            <label for="totalAmt">Costo</label>
            <input type="number" step="0.01" id="totalAmt" name="costo" class="form-control" placeholder="300.50">
            </div>
             <div class="col-12 pt-3">
                @php
                    $opciones = array(["id"=>1,"option"=>"Activo"],["id"=>0,"option"=>"Desactivado"])
                @endphp
                <x-dropdown-formulario label="Estatus" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" />
            </div>

                  
            <x-boton nombre_boton="Crear Costo" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </x-form-in-card>
@endif

@if ($accion=="edicion")
    <x-form-in-card :titulo="$titulo_formulario" :route="$route" :accion="$accion" :obj="$obj">
        <x-lista-mensajes/>
     
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="{{ $formulario }}"/>
            <x-select2 placeholder="Consultar otros conceptos" id="{{ $idSelect2 }}" name="id_concepto" />

            <h5 class="pt-5">Concepto: {{ $obj->nombre." (".$obj->codigo_concepto.")"; }}</h5>
            <p class="pt-2 text-primary">Periodo: {{ $obj->periodo }}</p>
            
            <div class="col-6 pt-3">
            <label for="totalAmt">Costo</label>
            <input type="number" step="1" id="totalAmt" name="costo" value="{{ $obj->costo }}" class="form-control" placeholder="300.50">
            </div>
             <div class="col-12 pt-3">
                @php
                    $opciones = array(["id"=>1,"option"=>"Activo"],["id"=>0,"option"=>"Desactivado"])
                @endphp
                <x-dropdown-formulario label="Estatus" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" :selected="$obj->activo"/>
            </div>

                  
            <x-boton nombre_boton="Crear Costo" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </x-form-in-card>
@endif