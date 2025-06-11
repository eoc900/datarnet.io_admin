<div class="multiple_inputs shadow mt-3">

<button type="button" class="remove_inputs btn btn-danger "><i class="lni lni-trash"></i></button>
<div class="row">
<div class="col-sm-6 pt-4">
    <label for="calle">Calle:</label>
    <input type="text" id="calle" name="calle[]"  class="form-control"
        value="{{ isset($direccion) ? $direccion->calle : old('calle') }}" required maxlength="32">
</div>

<div class="col-sm-3 pt-4">
    <label for="num_exterior">Número Exterior:</label>
    <input type="text" id="num_exterior" name="num_exterior[]"  class="form-control"
        value="{{ isset($direccion) ? $direccion->num_exterior : old('num_exterior') }}" required maxlength="7">

</div>

<div class="col-sm-3 pt-4">
    <label for="num_interior">Número Interior:</label>
    <input type="text" id="num_interior" name="num_interior[]" class="form-control"
        value="{{ isset($direccion) ? $direccion->num_interior : old('num_interior') }}" maxlength="7">
</div>

<div class="col-sm-6 pt-4">
    <label for="colonia">Colonia:</label>
    <input type="text" id="colonia" name="colonia[]" class="form-control"
        value="{{ isset($direccion) ? $direccion->colonia : old('colonia') }}" required maxlength="32">
</div>

<div class="col-sm-6 pt-4">
    <label for="codigo_postal">Código Postal:</label>
    <input type="text" id="codigo_postal" name="codigo_postal[]" class="form-control"
        value="{{ isset($direccion) ? $direccion->codigo_postal : old('codigo_postal') }}" required maxlength="7">
</div>
 <div class="col-sm-6 pt-4">
    <label for="codigo_postal">Ciudad:</label>
    <input type="text" id="ciudad" name="ciudad[]" class="form-control"
        value="{{ old('ciudad') }}" required maxlength="7">
</div>
<div class="col-sm-6 pt-4">
    <label for="codigo_postal">Estado:</label>
    <input type="text" id="estado" name="estado[]" class="form-control"
        value="{{ old('estado') }}" required maxlength="7">
</div>
</div>
</div>