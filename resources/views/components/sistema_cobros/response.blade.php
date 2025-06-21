
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
@if (session("error"))
        <div class="alert alert-danger border-0 bg-grd-danger alert-dismissible fade show">
    <div class="d-flex align-items-center">
        <div class="font-35 text-white"><i class="lni lni-cross-circle"></i>
        </div>
        <div class="ms-3">
        <h6 class="mb-0 text-white">Operación fallida</h6>
        <div class="text-white">{{ (session('error'))}}</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif