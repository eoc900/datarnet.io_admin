@extends('sistema_cobros.pages.cargos.layouts.create_layout')
@section('content')

    @if(session('success'))
        <div class="alert alert-success border-0 bg-grd-success alert-dismissible fade show">
          <div class="d-flex align-items-center">
            <div class="font-35 text-white"><span class="material-icons-outlined fs-2">check_circle</span>
            </div>
            <div class="ms-3">
              <h6 class="mb-0 text-white">Operación exitosa</h6>
              <div class="text-white">{{ (session('success'))}}</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

<x-form-in-card :titulo="$titulo_formulario" :route="$routeStore">
        <x-lista-mensajes/>
        <div class="row">
           <div class="col-12 pt-3">
              <label for="{{ $idSelect2 }}">Buscar alumno</label>
              <x-select2 placeholder="Buscar usuario o rol" id="{{ $idSelect2 }}" name="id_alumno" />
           </div>
            <div class="dropdown_cuentas">
                {{-- Aquí se agrega el html dinámico por medio de jquery --}}
            </div>
            <div class="dropdown_costos mt-3">
                {{-- Aquí se agrega el html dinámico por medio de jquery --}}
            </div>

            <x-campo-formulario label="Fecha de inicio" id="fecha_inicio" name="fecha_inicio" type="datetime-local" required="true"
                    parentClass="col-6 mt-4" />

            <x-campo-formulario label="Fin de ficha" id="fecha_fin" name="fecha_fin" type="datetime-local" required="true"
                            parentClass="col-6 mt-4" />


            <div class="col-6 pt-3">
                <div class="mt-4">
                  <label for="monto">Monto</label>
                <input type="number" step="0.01" id="monto" name="monto" class="form-control" placeholder="550.00">
                </div>
            </div>
          

            <x-boton nombre_boton="Registrar depósito" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
</x-form-in-card>

@endsection