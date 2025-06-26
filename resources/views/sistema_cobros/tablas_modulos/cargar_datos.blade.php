@extends('sistema_cobros.tablas_modulos.layouts.index')
@section("content")

<div class="card">
    <div class="card-body">
        @if (!isset($id_tabla))
            <h5>Carga de datos (1 sola hoja de excel)</h5>
        @endif

        <div class="col-sm-6 mb-4">
            <label for="seleccionar_tabla" class="form-label">Selecciona una tabla:</label>
            <form method="GET" action="{{ route('ver_cargar.datos') }}">
                <select name="id_tabla" id="seleccionar_tabla" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Elige una tabla --</option>
                    @foreach($tablasDisponibles as $tablaNombre)
                            @php
                                // Buscar el id real en la tabla_tablas_modulos
                                $tablaRecord = \App\Models\TablaModulo::where('nombre_tabla', $tablaNombre)->first();
                            @endphp
                            @if ($tablaRecord)
                                <option value="{{ $tablaRecord->id }}" {{ ($id_tabla == $tablaRecord->id) ? 'selected' : '' }}>
                                    {{ $tablaRecord->nombre_tabla }}
                                </option>
                            @endif
                        @endforeach

                </select>
            </form>
        </div>

        @include('components.sistema_cobros.response')
            @if (isset($id_tabla))


                <form class="row" method="post" action="{{ route('cargar.datos') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_tabla" value="{{ $id_tabla }}">

                        <div class="col-sm-12">
                        <h5 class="mt-5">La tabla: {{ $tabla }} cuenta con las siguientes columnas:</h5>
                            {{-- Alerta recomendación a usuario --}}
                            <div class="alert alert-warning border-0 bg-grd-warning alert-dismissible fade show mt-3">
                                <div class="d-flex align-items-center">
                                    <div class="font-35 text-dark"><span class="material-icons-outlined fs-2">report_problem</span>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="mb-0 text-dark">Verifica tu archivo primero</h6>
                                        <div class="text-dark">Por favor asegúrate de tener bien nombradas tus columnas de la siguiente manera.</div>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            {{-- Alerta recomendación a usuario --}}
                            <div class="input-group mt-3">
                                 @foreach ($columnas as $columna)
                           
                                <button type="button" class="btn btn-grd {{ ($columna->es_llave_primaria)?'btn-grd-success':'btn-grd-royal' }}">
                                    @if ($columna->es_llave_primaria)
                                        <i class="lni lni-key"></i>
                                    @endif
                                    {{ $columna->nombre_columna }}
                                </button>
                                @endforeach
                            </div>

                            <div class="bd-example">
                            <table class="table table-dark table-striped mt-3 bg-light">
                                <thead>
                                    <tr>
                                        @foreach ($columnas as $columna)
                                            <th class="text-center">{{ $columna->nombre_columna }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    @foreach ($columnas as $columna)
                                            <td class="text-center">...</td>
                                    @endforeach
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            
                        </div>
                           
                    
                        <div class="col-sm-6 mt-5">
                            <label for="archivo" class="form-label">Subir archivo CSV o Excel:</label>
                            <input type="file" class="form-control" name="archivo" id="archivo" accept=".csv, .xlsx" required>
                            <div class="form-check form-switch mt-3">
									<input class="form-check-input" type="checkbox" id="" checked="" name="ignorar_llaves_primarias">
									<label class="form-check-label" for="">Ignorar llaves primarias existentes</label>
							</div>
                            <div class="form-check form-switch mt-3">
									<input class="form-check-input" type="checkbox" id="" checked="" name="ignorar_campos_vacios">
									<label class="form-check-label" for="">Ignorar registros con campos vacíos</label>
							</div>
                        </div>
                        <x-boton nombre_boton="Cargar datos con excel" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
                </form>
            @endif
    </div>
</div>

@endsection