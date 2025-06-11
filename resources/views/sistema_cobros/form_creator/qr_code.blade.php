@extends('sistema_cobros.form_creator.layouts.show')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <div class="row">
            <div class="col-sm-8">
                <h3 class="mb-4">Generar Código QR</h3>
                <div class="form-group">
                    <label for="qr-url">Ingresa una URL:</label>
                    <input type="text" class="form-control" id="qr-url"
                        value="{{ isset($liga) ? route('formulario.publico', $liga->slug) : '' }}"
                        placeholder="https://ejemplo.com">
                </div>

                <button class="btn btn-primary mt-2" id="generar-qr">Generar QR</button>

            </div>

            <div class="col-sm-4 text-center">
                <div class="mt-4 text-center mx-auto" id="qrcode-container" style="min-height: 270px;">
                    <div class="mx-auto" id="qrcode"></div>
                </div>

                <button class="btn btn-success mt-3 d-none" id="descargar-qr">Descargar QR en PNG</button>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('qr_code')
    
<script src="https://cdn.jsdelivr.net/npm/qrcodejs/qrcode.min.js"></script>

<script>

    $(document).ready(function(){
            let qrcode;

            function generarQR(url) {
                $('#qrcode').empty();

                qrcode = new QRCode(document.getElementById("qrcode"), {
                    text: url,
                    width: 256,
                    height: 256,
                });

                setTimeout(() => {
                    $('#descargar-qr').removeClass('d-none');
                }, 300);
            }

            $('#generar-qr').click(function () {
                const url = $('#qr-url').val().trim();

                if (!url) {
                    alert('Por favor, ingresa una URL válida.');
                    return;
                }

                generarQR(url);
            });

            $('#descargar-qr').click(function () {
                const canvas = $('#qrcode canvas')[0];

                if (canvas) {
                    const link = document.createElement('a');
                    link.href = canvas.toDataURL("image/png");
                    link.download = "codigo_qr.png";
                    link.click();
                } else {
                    alert('Primero genera el código QR.');
                }
            }); 

              const precarga = $('#qr-url').val();
                if (precarga) {
                    generarQR(precarga);
                }
    });
   
</script>

@endpush

