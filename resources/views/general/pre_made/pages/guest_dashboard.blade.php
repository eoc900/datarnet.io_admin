@extends('general.pre_made.layouts.index')
@section("content")

    <div class="row">
        <div class="card">
              <img src="{{ asset('dashboard_resources/assets/images/auth/Panel_De_Control_Guest.jpg') }}" class="img-fluid card-img-top" alt="">
              <div class="card-body p-4">
                <h3 class="text-center">Bienvenid@ a tu panel de control</h3>
                @if (Auth::user()->hasRole("Guest"))
                    <div class="alert alert-warning">
                        <p><b>Instrucciones:</b></p>
                        <ol>
                            <li>Esperar a que se te asignen los permisos correspondientes (puede llevar hasta 24 horas).</li>
                            <li>Recibirás un aviso por parte del administrador cuando ya tengas tus accesos.</li>
                            <li>Una vez recibidos tus accesos esperarás a que se te capacite para usar las funciones de este sistema.</li>
                            <li>Se agendará una breve capacitación de este sistema así que no te preocupes.</li>
                        </ol>
                        <p class="text-center"><b>¡Gracias por formar parte del equipo!</b></p>
                    </div>
                @endif
                 @if (!Auth::user()->hasRole("Guest"))
                    <div class="alert alert-success">
                        <p><b>Tu cuenta ha sido valida:</b></p>
                        <p class="text-center"><b>¡Gracias por formar parte del equipo!</b></p>
                    </div>
                @endif
            
  
               
            </div>

    </div>


@endsection