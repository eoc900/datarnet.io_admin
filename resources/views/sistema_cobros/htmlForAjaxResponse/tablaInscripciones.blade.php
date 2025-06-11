
<div class="mb-5 mt-4 ps-5 pe-5">
<h4><b>Nombre: </b>{{ $alumno->alumno }}</h4>
<p><b>Matrícula: </b>{{ $alumno->matricula }}</p>
<p><b>Sistema: </b>{{ $alumno->codigo_sistema }} </p>
<p><b>Escuela: </b>{{ $alumno->codigo_escuela }}  </p>
<input type="hidden" name="id_sistema" id="id_sistema" value="{{ $alumno->id_sistema_academico }}">
</div>

<div class="ps-5 pe-5">
<table class="table table-striped table-bordered inscripciones">
<thead class="table-dark">
    <tr>
        <th>#</th>
        <th>ID Inscripción</th>
        <th>Período</th>
        <th>Total de Materias</th>
    </tr>
</thead>
<tbody>
    <!-- Datos dinámicos -->
    @foreach ($inscripciones as $index => $inscripcion)
    <tr>
        <td>{{ $index + 1 }}</td>
        <td>{{ $inscripcion->tipo_inscripcion }}</td>
        <td>{{ $inscripcion->periodo }}</td>
        <td>{{ $inscripcion->materias_inscritas }}</td>
        <td><button type="button" class="btn btn-primary cargar_materias" data-inscripcion="{{ $inscripcion->id}}" data-periodo="{{ $inscripcion->periodo}}">Cargar materias +</button></td>
    </tr>
    @endforeach
</tbody>
</table>

<p>Periodo seleccionado: <span class="text-danger periodo_seleccionado"> Aún no seleccionas un periodo</span></p>
<input type="hidden" name="id_inscripcion" id="id_inscripcion" value="">
<input type="hidden" name="periodo" id="periodo" value="">
</div>


<div class="contenedor_inputs ps-5 pb-5">
    
    <label class="mt-4">Selecciona una materia</label>
    <select name="materias[]" class="form-control">
    @foreach ($materias as $materia)
        <option value="{{ $materia->id }}">{{ $materia->materia }} | Cuatrimestre: {{ $materia->cuatrimestre }} | Créditos: {{ $materia->creditos }} </option>
    @endforeach
    </select>
</div>
