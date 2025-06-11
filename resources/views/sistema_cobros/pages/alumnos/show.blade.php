@extends('sistema_cobros.layouts.index')
@section("content")
    <x-page-breadcrumb :titulo="$titulo_breadcrumb" :subtitulo="$subtitulo_breadcrumb" />


     <div class="card rounded-4">
          <div class="card-body p-4">
            
             <div class="position-relative mb-5 background-profile rounded-3">
   
              <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                <img src="{{ asset("dashboard_resources/assets/images/avatars/alumno.png"); }}" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="170" height="170" alt="">
              </div>
             </div>
             @include("general/partials/alertsTopSection")
              <div class="profile-info pt-5 text-center">
     
                  <h3 class="text-center mt-5">{{ $alumno->alumno }}</h3>
    
              </div>
          </div>
    </div>

    <div class="row">
           <div class="col-12 col-xl-8">
            <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
            <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                    <div class="">
                        <h5 class="mb-0 fw-bold">Información general</h5>
                    </div>
                    </div>
					
                    <div class="col-12">
                    <b>Periodo actual:</b> {{ App\Helpers\PagosDiferidos::periodoActual(); }} | Inicia: {{ $fechasPeriodo['fecha_inicio']}} Finaliza: {{ $fechasPeriodo['fecha_fin'] }}
                    </div>
                    @if ($cuentas)
                        <div class="col-12 pt-3">
                        <x-dropdown-formulario label="Cuentas" id="id_cuentas" :options="$cuentas" value-key="id" option-key="cuatrimestre" simpleArray="false" name="id_cuenta"
                        extras="true">
                              @foreach ($cuentas as $cuenta=>$array)
                                <option value="{{ $array->id }}">Cuatrimestre: {{ $array->cuatrimestre }} | Configuración pagos: {{ $array->dist_pagos_cuatri}} | Cuenta: {{ ($array->activa)?"Activa":"Inactiva"}} </option>
                            @endforeach
                        </x-dropdown-formulario>
                        </div>
                    @endif		
                    @if (!$cuentas)
                        <div class="col-12 pt-3">
                            <div class="alert alert-warning">No hay cuentas enlazadas al alumno...</div>
                        </div>
                    @endif

                    <div class="renderSection" id="{{ $renderSectionID }}">
                      
                    </div>

                    <hr>
                    <h5 class="mt-5">Cargos referentes a la cuenta</h5>
                    <div class="cargos_cuenta"></div>

                     <h5 class="mt-5">Pagos referentes a la cuenta</h5>
                    <div class="pagos_cuenta"></div>


                 

                    <a href="{{ url('/formulario/enlace_cuenta_alumno?alumno='.$alumno->id_alumno); }}" class="mt-5 btn btn-primary">Añadir una cuenta </a>

            </div>			
            </div>
           </div>  
           <div class="col-12 col-xl-4">
            <div class="card rounded-4">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <div class="">
                    <h5 class="mb-0 fw-bold">Acerca de</h5>
                  </div>
                 
                 </div>
                 <div class="full-info">
                  <div class="info-list d-flex flex-column gap-3">
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">account_circle</span><p class="mb-0">Nombre completo: {{ $alumno->alumno }}</p></div>
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span><p class="mb-0">Estatus: {{ ($alumno->activo)?"Activo":"Baja" }} </p></div>
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">code</span><p class="mb-0">Escuela: <b>{{ $alumno->codigo_escuela }}</b></p></div>
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">code</span><p class="mb-0">Sistema: <b>{{ $alumno->codigo_sistema }}</b></p></div>
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">flag</span><p class="mb-0">País: Méx</p></div>
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">send</span><p class="mb-0">Email: {{ $alumno->email }} </p></div>
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">call</span><p class="mb-0">Phone: {{ $alumno->telefono }} </p></div>
                  </div>
                </div>
              </div>
            </div>
           

           </div>
        </div>
    
@endsection