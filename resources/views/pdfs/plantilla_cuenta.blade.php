@extends('pdfs.layouts.index')
@section("content")
    <div class="heading">
     

        <div class="info-escuela">
            <h3>{{ $info["cuenta"][0]->escuela; }}</h3>
            <p>{{ $info["cuenta"][0]->calle; }} #{{ $info["cuenta"][0]->num_exterior; }}, {{ $info["cuenta"][0]->colonia; }} {{ $info["cuenta"][0]->codigo_postal; }} <br>
                {{ $info["cuenta"][0]->ciudad; }}, {{ $info["cuenta"][0]->estado; }}.    
            </p>
            <p><b>Teléfono:</b> 4610000001</p>
            <p><b>Correo coordinación:</b> coordinacion@cegto.com.mx</p>
            <p><b>Correo soporte técnico:</b> soporte@cegto.com.mx</p>
        </div>
        <div class="logo">
            {{-- <img src="{{ public_path("centro_estudios/assets/img/logo/".$info["cuenta"][0]->imagen_logo);}}" alt=""> --}}
            <img src="{{ public_path('storage/logos/'.$info["cuenta"][0]->imagen_logo); }}" alt="{{ public_path('storage/logos/'.$info["cuenta"][0]->imagen_logo); }}">
        </div>
    </div>
  
     <div class="flex">
    
        <table class="alumno">
            <tbody>
                <tr>
                    <td>Matrícula</td>
                    <td>{{ $info["cuenta"][0]->matricula; }}</td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td>{{ $info["cuenta"][0]->nombre_alumno; }}</td>
                </tr>
                <tr>
                    <td>Apellido Paterno</td>
                    <td>{{ $info["cuenta"][0]->apellido_paterno; }}</td>
                </tr>
                <tr>
                    <td>Apellido Materno</td>
                    <td>{{ $info["cuenta"][0]->apellido_materno; }}</td>
                </tr>
            </tbody>
        </table>

        <table class="fechas">
            <tbody>
                <tr>
                    <td>Periodo actual</td>
                    <td>{{ $info["fecha_inicio"] }}-{{ $info["vencimiento"] }} del {{ $info["anio"] }}</td>
                </tr>
                <tr>
                <td>Sistema Académico</td>
                <td>{{ $info["cuenta"][0]->sistema; }}</td>
                </tr>
            </tbody>
        </table>
        <table class="sistema">
        <tbody>
             
        </tbody>
    </table>
    </div>
    
    

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
                @foreach ($info['pagos_pendientes'] as $pago)
                    <tr>
                        <td>{{ $pago->num_cargo; }}</td>
                        <td>{{ $pago->codigo_concepto }}</td>
                        <td>{{ Carbon\Carbon::parse($pago->fecha_inicio)->isoFormat('D [de] MMMM') }}-{{ Carbon\Carbon::parse($pago->fecha_finaliza)->isoFormat('D [de] MMMM') }} </td>
                        <td>{{ $pago->monto; }}</td>
                        <td>
                        @if ($pago->tipo_descuento=="porcentaje")
                            {{ $pago->monto * $pago->tasa_descuento  }}
                        @endif
                        @if ($pago->tipo_descuento=="fijo")
                            {{ $pago->monto_descuento  }}
                        @endif
                        @if ($pago->tipo_descuento==0)
                            0
                        @endif
                        </td>
                        <td>
                            @if ($pago->tipo_descuento=="porcentaje")
                            {{ $pago->monto-($pago->monto * $pago->tasa_descuento)  }}
                            @endif
                            @if ($pago->tipo_descuento=="fijo")
                                {{ $pago->monto-$pago->monto_descuento  }}
                            @endif
                            @if ($pago->tipo_descuento==0)
                                {{ $pago->monto; }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total">
            <h3>Total a pagar: ${{ $info['totalPagar'] }}</h3>
        </div>
    </div>

@endsection