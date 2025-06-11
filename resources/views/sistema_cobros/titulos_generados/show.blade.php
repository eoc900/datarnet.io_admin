@extends('sistema_cobros.tipos_correos.layouts.index')
@section("content")
   <div class="card">
    <div class="card-header"> <h5>Información del titulo</h5></div>
    <div class="card-body">       
      
        <p>Alumno: {{ $titulo->alumno }}</p>
        <p>Emitido por: {{ $titulo->emitidoPor }}</p>
        <p>Fecha emisión: {{ $titulo->fecha_expedicion }}</p>
        <p>Estado: {{ ($titulo->estado)?"Validado":"Sin validar"}}</p>

        <table class="table table-striped table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Campo</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <tr><td>ID</td><td>{{ $titulo->id }}</td></tr>
        <tr><td>ID Alumno</td><td>{{ $titulo->id_alumno }}</td></tr>
        <tr><td>Fecha Expedición</td><td>{{ $titulo->fecha_expedicion }}</td></tr>
        <tr><td>Estado</td><td>{{ $titulo->estado ? 'Validado' : 'Sin validar' }}</td></tr>
        <tr><td>Emitido Por</td><td>{{ $titulo->emitidoPor }}</td></tr>
        <tr><td>Aprobado Por</td><td>{{ $titulo->aprobadoPor ?? 'Sin asignar' }}</td></tr>
        <tr><td>Número de Lote</td><td>{{ $titulo->num_lote ?? 'Sin asignar' }}</td></tr>
        <tr><td>ID Institución</td><td>{{ $titulo->id_institucion }}</td></tr>
        <tr><td>Clave Carrera</td><td>{{ $titulo->cve_carrera }}</td></tr>
        <tr><td>Fecha Inicio</td><td>{{ $titulo->fecha_inicio ?? 'Sin asignar' }}</td></tr>
        <tr><td>Fecha Terminación</td><td>{{ $titulo->fecha_terminacion }}</td></tr>
        <tr><td>Modalidad Titulación</td><td>{{ $titulo->modalidad_titulacion }}</td></tr>
        <tr><td>Fecha Examen Profesional</td><td>{{ $titulo->fecha_examen_profesional ?? 'Sin asignar' }}</td></tr>
        <tr><td>Fecha Exención Examen</td><td>{{ $titulo->fecha_exencion_examen ?? 'Sin asignar' }}</td></tr>
        <tr><td>Cumplió Servicio Social</td><td>{{ $titulo->cumplio_servicio_social ? 'Sí' : 'No' }}</td></tr>
        <tr><td>ID Entidad Expedición</td><td>{{ $titulo->id_entidad_expedicion }}</td></tr>
        <tr><td>ID Servicio Social</td><td>{{ $titulo->id_servicio_social }}</td></tr>
        <tr><td>ID Autorización</td><td>{{ $titulo->id_autorizacion }}</td></tr>
        <tr><td>Nombre Institución Antecedente</td><td>{{ $titulo->nombre_institucion_antecedente }}</td></tr>
        <tr><td>Tipo Estudio Antecedente</td><td>{{ $titulo->tipo_estudio_antecedente }}</td></tr>
        <tr><td>ID Entidad Estudios Antecedentes</td><td>{{ $titulo->id_entidad_estudios_antecedentes }}</td></tr>
        <tr><td>Fecha Inicio Antecedente</td><td>{{ $titulo->fecha_inicio_antecedente }}</td></tr>
        <tr><td>Fecha Terminación Antecedente</td><td>{{ $titulo->fecha_terminacion_antecedente }}</td></tr>
    </tbody>
</table>

      
        

        <a href="{{ route("ver_xml",$titulo->id) }}" class="btn btn-success">Ver documento xml</a>
        <a href="{{ route("prueba_soap",$titulo->id) }}" class="btn btn-primary">Enviar xml</a>

        @if (isset($titulo->num_lote))
            <a href="{{ route("consultar_lote",$titulo->id) }}" class="btn btn-info">Consultar lote</a>
            <a href="{{ route("descargar_lote",$titulo->num_lote) }}" class="btn btn-success">Descargar lote</a>
        @endif
    </div>
   </div>
@endsection