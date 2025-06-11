@extends('pdfs.layouts.index')
@section("content")
    <div class="heading">
        <div class="info-escuela">
            <h3>Centro de Estudios de Celaya</h3>
            <p>Guadalupe #105, Zona Centro 38000 <br>
                Celaya, Gto.    
            </p>
            <p><b>Teléfono:</b> 4610000001</p>
            <p><b>Correo coordinación:</b> coordinacion@cegto.com.mx</p>
            <p><b>Correo soporte técnico:</b> soporte@cegto.com.mx</p>
        </div>
        <div class="logo">
            <img src="{{ public_path("centro_estudios/assets/img/logo/logo-centro-de-estudios-de-celaya.png");}}" alt="">
            {{-- <img src="{{ url("centro_estudios/assets/img/logo/logo-centro-de-estudios-de-celaya.png");}}" alt=""> --}}
        </div>
    </div>
  
    <div class="flex">
    
        <table class="alumno">
            <tbody>
                <tr>
                    <td>Matrícula</td>
                    <td>10203910</td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td>Benancio Alan</td>
                </tr>
                <tr>
                    <td>Apellido Paterno</td>
                    <td>Gamez</td>
                </tr>
                <tr>
                    <td>Apellido Materno</td>
                    <td>Enriques</td>
                </tr>
            </tbody>
        </table>

        <table class="fechas">
            <tbody>
                <tr>
                    <td>Periodo actual</td>
                    <td>Enero - Abril del 2024</td>
                </tr>
            </tbody>
        </table>
    </div>
    
     <table class="sistema">
        <tbody>
             <tr>
                <td>Sistema Académico</td>
                <td>LD</td>
            </tr>
        </tbody>
    </table>

    <div class="tabla">
        <h2>Desglose cuenta a la fecha actual: {{ \Carbon\Carbon::now()->isoFormat('D [de] MMMM [de] YYYY'); }}</h2>

        <table class="deglose">
            <thead>
                <tr>
                    <th>Num.</th>
                    <th>Ref.</th>
                    <th>Periodo.</th>
                    <th>Monto</th>
                    <th>Descuento</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Col20241</td>
                    <td>Ene-Feb[2024]</td>
                    <td>$750</td>
                    <td>$0</td>
                    <td>$750</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Col20241</td>
                    <td>Feb-Mar[2024]</td>
                    <td>$750</td>
                    <td>$0</td>
                    <td>$750</td>
                </tr>
                 <tr>
                    <td>1</td>
                    <td>Col20241</td>
                    <td>Ene-Feb[2024]</td>
                    <td>$750</td>
                    <td>$0</td>
                    <td>$750</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Col20241</td>
                    <td>Feb-Mar[2024]</td>
                    <td>$750</td>
                    <td>$0</td>
                    <td>$750</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            <h3>Total a pagar: $750.00 MXN</h3>
        </div>
    </div>

@endsection