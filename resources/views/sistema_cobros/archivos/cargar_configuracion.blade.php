@extends('sistema_cobros.archivos.layouts.index')

@section("content")
<h1>Carga tus archivos aquí</h1>

<div class="card">
    <div class="card-body">
        <form id="upload-form" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="col-xl-9 mx-auto">
                <h6 class="mb-0 text-uppercase">Fancy File Upload</h6>
                <hr>
                <div class="card">
                    <div class="card-body">
                        <input id="fancy-file-upload" type="file" name="files[]" accept=".json" multiple>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 d-none contenedor-procesar text-center">
                            <div class="alert alert-secondary border-0 bg-grd-voilet alert-dismissible fade show">
									<div class="d-flex align-items-center">
										<div class="font-35 text-white"><span class="material-icons-outlined fs-2">report_gmailerrorred</span>
										</div>
										<div class="ms-3">
											<h6 class="mb-0 text-white">Aviso</h6>
											<div class="text-white">Una vez cargados todos tus archivos de configuración podrás comenzar la instalación con el botón inferior.</div>
										</div>
									</div>
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
                <div class="btn btn-success"><i class="lni lni-spinner"></i> Procesar aplicación</div>
            </div>
        </form>
    </div>
</div>
@endsection

@push("cargar_configuracion")
<!-- Fancy File Uploader dependencies -->
<script src="{{ asset('dashboard_resources/assets/plugins/fancy-file-uploader/jquery.ui.widget.js') }}"></script>
<script src="{{ asset('dashboard_resources/assets/plugins/fancy-file-uploader/jquery.fileupload.js') }}"></script>
<script src="{{ asset('dashboard_resources/assets/plugins/fancy-file-uploader/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('dashboard_resources/assets/plugins/fancy-file-uploader/jquery.fancy-fileupload.js') }}"></script>

<script>
    $(document).ready(function () {
        
        $('#fancy-file-upload').FancyFileUpload({
            url:'{{ route("carga.configuracion") }}',
            params: {
                _token: '{{ csrf_token() }}',
                action: '{{ route("carga.configuracion") }}'
            },
            maxfilesize: 1000000,
            fileupload: {
                type: 'POST',
                dataType: 'json'
            },
            uploadcompleted: function (e, data) {
           
                console.log(data.result);

                if (data.result.success) {
                    alert(data.result.mensaje);
                } else {
                    alert('Error: ' + data.result.mensaje);
                }

                if(data.result.mostrar_procesar){
                    $(".contenedor-procesar").removeClass("d-none");
                }
           
            }
        });

        //$('.ff_fileupload_hidden').attr("action","{{ route("carga.configuracion") }}");
    });
</script>
@endpush
