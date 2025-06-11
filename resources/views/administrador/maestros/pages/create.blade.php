@extends('administrador.maestros.layouts.index')
@section("content")
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session("success"))
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
    <!-- Datos personales -->

    <h5 class="mb-4">Crear un nuevo maestro</h5>
    <form method="post" action="{{ route('maestros.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="col-md-12">
        <label for="input13" class="form-label"><b>Estatus actual sistema</b></label>
        <select id="input21" class="form-select" name="estado_sistema">
                <option selected value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
        </select>
        </div>
        <div class="col-md-6">
            <label for="input13" class="form-label">Nombre</label>
            <div class="position-relative input-icon">
                <input type="text" class="form-control" id="input13" name="nombre" placeholder="Nombre" >
                <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">person_outline</i></span>
            </div>
        </div>
        <div class="col-md-6">
            <label for="input14" class="form-label">Apellido paterno</label>
            <div class="position-relative input-icon">
                <input type="text" class="form-control" id="input14" name="apellido_paterno" placeholder="Apellido Paterno" >
                <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">person_outline</i></span>
            </div>
        </div>
        <div class="col-md-6">
            <label for="input14" class="form-label">Apellido materno</label>
            <div class="position-relative input-icon">
                <input type="text" class="form-control" id="input143" name="apellido_materno" placeholder="Apellido Materno" >
                <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">person_outline</i></span>
            </div>
        </div>
        <div class="col-md-12">
            <label for="input15" class="form-label">Telefono</label>
            <div class="position-relative input-icon">
                <input type="text" class="form-control" id="input15" name="telefono" placeholder="Telefono">
                <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">call</i></span>
            </div>
        </div>
        <div class="col-md-12">
            <label for="input16" class="form-label">Correo Personal</label>
            <div class="position-relative input-icon">
                <input type="text" class="form-control" id="input16" name="correo_personal" placeholder="Correo Personal" >
                <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">email</i></span>
            </div>
        </div>
        <div class="col-md-12">
            <label for="input16" class="form-label">Correo Institucional</label>
            <div class="position-relative input-icon">
                <input type="text" class="form-control" id="input162" name="correo_institucional" placeholder="Correo Institucional" >
                <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">email</i></span>
            </div>
        </div>
            <div class="col-md-12">
            <label for="input23" class="form-label">Direccion calle</label>
            <textarea class="form-control" id="input23" name="calle" placeholder="Calle" rows="3" placeholder="Calle y número"></textarea>
        </div>
            <div class="col-md-4">
            <label for="input22" class="form-label">Código Postal</label>
            <div class="position-relative input-icon">
                <input type="text" class="form-control" id="input22" name="codigo_postal" placeholder="Código Postal" >
                <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">location_on</i></span>
            </div>
        </div>
        <div class="col-md-4">
            <label for="input20" class="form-label">Ciudad</label>
            <div class="position-relative input-icon">
                <input type="text" class="form-control" id="input20" name="ciudad" placeholder="Ciudad" >
                <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">location_city</i></span>
            </div>
        </div>
        <div class="col-md-4">
            <label for="input21" class="form-label">Estado</label>
            <select id="input21" class="form-select" name="estado">
        
                
                        <option value="aguascalientes">Aguascalientes</option>
                        <option value="baja california">Baja California</option>
                        <option value="baja california sur">Baja California Sur</option>
                        <option value="campeche">Campeche</option>
                        <option value="chiapas">Chiapas</option>
                        <option value="chihuahua">Chihuahua</option>
                        <option value="coahuila">Coahuila</option>
                        <option value="colima">Colima</option>
                        <option value="durango">Durango</option>
                        <option value="guanajuato">Guanajuato</option>
                        <option value="guerrero">Guerrero</option>
                        <option value="hidalgo">Hidalgo</option>
                        <option value="jalisco">Jalisco</option>
                        <option value="ciudad de mexico">Ciudad de México</option>
                        <option value="estado de mexico">Estado de México</option>
                        <option value="michoacan">Michoacán</option>
                        <option value="morelos">Morelos</option>
                        <option value="nayarit">Nayarit</option>
                        <option value="nuevo leon">Nuevo León</option>
                        <option value="oaxaca">Oaxaca</option>
                        <option value="puebla">Puebla</option>
                        <option value="queretaro">Querétaro</option>
                        <option value="quintana roo">Quintana Roo</option>
                        <option value="san luis potosi">San Luis Potosí</option>
                        <option value="sinaloa">Sinaloa</option>
                        <option value="sonora">Sonora</option>
                        <option value="tabasco">Tabasco</option>
                        <option value="tamaulipas">Tamaulipas</option>
                        <option value="tlaxcala">Tlaxcala</option>
                        <option value="veracruz">Veracruz</option>
                        <option value="yucatan">Yucatán</option>
                        <option value="zacatecas">Zacatecas</option>


                
            </select>
        </div>
        <div class="col-md-12">
            <label for="input18" class="form-label">Inicio contrato</label>
            <div class="position-relative input-icon">
                <input type="text" class="form-control" id="input18" name="inicio_contrato" placeholder="Inicio Contrato" >
                <span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">event</i></span>
            </div>
        </div>
    
        <div class="col-md-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="input24">
                <label class="form-check-label" for="input24">Check me out</label>
            </div>
        </div>
        <div class="col-md-12">
            <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                <button type="submit" class="btn btn-grd-success float-end px-4">Submit</button>
            
            </div>
        </div>
    </form>

<!-- Datos personales -->
@endsection