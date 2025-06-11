<div class="modal fade" id="reescribir"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header border-bottom-0 py-2 bg-grd-info">
        <h5 class="modal-title text-white">Cambiar correo de CCuenta</h5>
        <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="modal">
            <i class="material-icons-outlined">close</i>
        </a>
        </div>
        <div class="modal-body">
        <div class="form-body">
            @include('components.sistema_cobros.response')
            <form class="row g-3" action="{{ route('correos_asociados.update', $alumno_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-6">
                <label for="input1" class="form-label">Correo electrónico actual</label>
                <input type="text" class="form-control" id="ccuenta" placeholder="First Name" name="ccuenta" value="{{ $ccuenta }}">
            </div>
            <div class="col-md-12">
                <div class="d-md-flex d-grid align-items-center gap-3">
                <button type="submit" class="btn btn-grd-danger px-4 text-white"><i class="lni lni-pencil-alt"></i> Cambiar</button>
                <button type="button" class="btn btn-grd-info px-4 text-white reenviar_bienvenida"><i class="lni lni-envelope"></i> Re-envío</button>
                </div>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div>
</div>