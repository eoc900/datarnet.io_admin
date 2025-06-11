<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
        <link href="{{ asset("dashboard_resources/assets/plugins/fullcalendar/css/main.min.css") }}" rel="stylesheet">
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <link href="{{  asset("dashboard_resources/assets/css/style.css");}}" rel="stylesheet">
</head>
<body>
    @include('general.partials.header')
    @include('general.partials.sidebar')

      <main class="main-wrapper">
        {{-- <p>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data[0]->hora_finaliza, 'America/Mexico_City')->format('Y-m-d\TH:i:sP') }}</p> --}}
        {{-- <p>{{ \Carbon\Carbon::parse($data[0]->hora_finaliza)->setTimezone('America/Mexico_City')->format('Y-m-d\Th:i:s'); }}</p> --}}
        <div class="main-content">
            @yield('content')
        </div>
    </main>


    @include('general.partials.scripts')
    <script src="{{  asset("dashboard_resources/assets/plugins/fullcalendar/js/main.min.js");}}"></script>

    <script>
      $(document).ready(function(){

        console.log("");
      var events = [
          @if(count($data)>0)
            @foreach ($data as $hora)
              { 
                id: "{{ $hora->id }}",
                extendedProps: {evento: "{{ $hora->id }}",fin: "{{ \Carbon\Carbon::parse($hora->hora_finaliza)->setTimezone('America/Mexico_City')->format('Y-m-d\Th:i:sP');}}"},
                title: "Disponible",
                start: "{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$hora->hora_inicio, 'America/Mexico_City')->format('Y-m-d\TH:i:sP') }}",
                end: "{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$hora->hora_finaliza, 'America/Mexico_City')->format('Y-m-d\TH:i:sP') }}",
            @switch($hora->marcar_como)
              @case("Pendiente")
                  className: "bg-danger view_task",
              @break
              @case("En Progreso")
                  className: "bg-primary text-white view_task",
              @break
              @case("Completada")
                  className: "bg-info view_task",
              @break
              @case("Disponible")
                  className: "bg-success view_task",
              @break
              @case("Reformular")
                  className: "bg-warning view_task",
              @break
            @endswitch
                color: "white"
              } 
              @if($data[count($data)-1]!=$hora)
              {{ "," }}
              @endif
            @endforeach
          @endif
        ];

        console.log(events);
      var calendarEl = document.getElementById('calendar');
			var calendar = new FullCalendar.Calendar(calendarEl, {
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					// right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
          right: 'timeGridWeek,listWeek'
				},
        timeZone: 'local',
				initialView: 'timeGridWeek',
				initialDate: '{{ (count($data)>0)?\Carbon\Carbon::parse($data[0]->hora_inicio)->format('Y-m-d'):\Carbon\Carbon::now(); }}',
				navLinks: true, // can click day/week names to navigate views
				selectable: true,
				nowIndicator: true,
				dayMaxEvents: true, // allow "more" link when too many events
				editable: true,
				selectable: true,
				businessHours: true,
				dayMaxEvents: true, // allow "more" link when too many events
				events: events,
        select: function(info){
          console.log('Seleccionado desde:', (new Date(info.startStr)).toISOString().slice(0, 19), 'hasta:', info.endStr);
          console.log(info);
          openModal((new Date(info.startStr)).toISOString().slice(0, 19),(new Date(info.endStr)).toISOString().slice(0, 19));
        },
        eventClick: function(info) {
         
          console.log(info.event._def.publicId);
          let id = info.event._def.publicId;
          openModalEliminar(id);
        // Opcional: Mostrar un alert con el código del evento
     
        },
				eventDidMount: function(info) {
            // Access custom properties here
					var task = info.event.extendedProps.task;
					
					info.el.setAttribute('data-task', task);
				

					console.log(info);
				}
			
			});
			calendar.render();


      function eventoAceptar(){
        $("#aceptar_horario").off();
        $("#aceptar_horario").click(function(){
            var val1 = $('.inicio').attr('data-inicio');
            var val2 = $('.fin').attr('data-fin');
            enviar(val1,val2);
        });
      }
      function eventoAceptarEliminar(){
        $("#aceptar_eliminar_horario").off();
        $("#aceptar_eliminar_horario").click(function(){
            var val1 = $('#eliminar_hora').val();
            enviarEliminar(val1);
        });
      }
      eventoAceptar();
      eventoAceptarEliminar();

      function openModal(i,f){
         const modalElement = document.getElementById('horario_modal');
        
        //   // Asegúrate de que el modal existe antes de interactuar con él
          if (modalElement) {
              const myModal = new bootstrap.Modal(modalElement);
              myModal.show();
                $('.inicio').attr('data-inicio',i);
                $('.fin').attr('data-fin',f);
                $('.inicio').html(i);
                $('.fin').html(f);

          } else {
              console.error('El modal no fue encontrado en el DOM.');
          }
      }
      function openModalEliminar(hora_eliminar){
         const modalElement = document.getElementById('eliminar_horario');
        
        //   // Asegúrate de que el modal existe antes de interactuar con él
          if (modalElement) {
              const myModal = new bootstrap.Modal(modalElement);
              myModal.show();
                $('#eliminar_hora').val(hora_eliminar);

          } else {
              console.error('El modal no fue encontrado en el DOM.');
          }
      }

      function enviar(i,f){
         $.ajax({
              url: '{{ route("asignar_disponibilidad") }}',
              method: "post",
              data: {_token:'{{csrf_token()}}',inicio: i,fin: f, maestro:"{{ $maestro }}"},
              success: function(response){
                 console.log(response);
                  window.location.reload();
              }
          })
      }
      function enviarEliminar(hora){
         $.ajax({
              url: '{{ route("eliminar_hora_disponible") }}',
              method: "post",
              data: {_token:'{{csrf_token()}}',id_hora: hora, maestro:"{{ $maestro }}"},
              success: function(response){
                 console.log(response);
                  window.location.reload();
              }
          })
      }

      });
    </script>
</body>
</html>