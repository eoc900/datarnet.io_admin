 <div class="multiple_inputs shadow mt-3">
        <button type="button" class="remove_inputs btn btn-danger"><i class="lni lni-trash"></i></button>

        <select name="materias[]" class="form-control">
        @foreach ($materias as $materia)
            <option value="{{ $materia->id }}">{{ $materia->materia }} | Cuatrimestre: {{ $materia->cuatrimestre }} | Créditos: {{ $materia->creditos }}  </option>
        @endforeach
        </select>
 </div>