
    <div class="multiple_inputs shadow mt-3">
        <button type="button" class="remove_inputs btn btn-danger"><i class="lni lni-trash"></i></button>
        <x-dropdown-anio label="Selecciona el año" id="anio" name="anio[]" />
        <x-dropdown-cuatrimestre label="Selecciona el cuatrimestre" id="cuatri" name="cuatri[]" />
        <x-dropdown-formulario label="Tipo de inscripción" id="activo" :options="$tipos_inscripcion" value-key="id" option-key="option" simpleArray="true" name="tipo_inscripcion[]" />
    </div>
