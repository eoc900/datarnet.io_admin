@extends('sistema_cobros.descuentos.layouts.aplicar_descuento_layout')
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
     @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
      @endif

<x-form-in-card titulo="Aplicar un descuento a cuenta" route="aplicar_descuento.store">
    <label for="buscarAlumno">Buscar alumno</label>
    <x-select2 placeholder="Buscar alumno por nombre" id="buscarAlumno" name="id_alumno" />
    
    <label for="buscarDescuento" class="mt-3">Buscar Descuentos</label>
    <x-select2 placeholder="Buscar descuento por nombre o descripcion" id="buscarDescuento" name="descuento" />

    <fieldset class="mt-3">
    <p>Aplicar el descuento como:</p>
      <div>
        <input type="radio" id="porcentaje" name="tipo_descuento" value="porcentaje" checked />
        <label for="porcentaje">Porcentaje (aplicado una sóla vez)</label>
      </div>
      <div>
        <input type="radio" id="fijo" name="tipo_descuento" value="fijo" />
        <label for="fijo">Valor Fijo</label>
      </div>
    </fieldset>
    
    <div class="dropdownCuentas" id="dropdownCuentas">
    </div>

    <div class="checkbox-pagos mt-5">
    </div>

    <button type="submit" class="btn btn-success">Aplicar descuento</button>
</x-form-in-card>

@endsection