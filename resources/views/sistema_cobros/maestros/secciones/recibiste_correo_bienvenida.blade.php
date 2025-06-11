@if (isset($ccuenta) && $ccuenta->activo)
    <div class="alert alert-success">
       <h5>Parece que el alumno asoció su correo CCuenta exitosamente</h5>
       <p>¿Quieres proceder a realizar su inscripción?</p>
        <a href=""></a>
    </div>
@elseif(isset($ccuenta) && !$ccuenta->activo)
    <div class="alert alert-warning">
       <h5>¡Parece que el alumno aún no enlaza su correo.!</h5>
       <p class="information"><span class="text-primary"><i class="lni lni-question-circle"></i> ¿Qué hacer?</span> pregúntale si ya recibió su correo de bienvenida.</p>
       <div class="d-flex border p-5">
            <p><b>¿Su correo está bien escrito: {{ $ccuenta->ccuenta }}?</b></p>
            <div class="d-flex justify-content-end ms-5">
                <button class="btn btn-info justify-content-end">Si</button>
                <button class="btn btn-warning justify-content-end" type="button" data-bs-toggle="modal" data-bs-target="#reescribir">No</button>
            </div>
       </div>
       
    </div>
@else
<div class="alert alert-danger">
        No pudimos detectar la ccuenta de este alumno. Contacta a informática.
</div>
@endif