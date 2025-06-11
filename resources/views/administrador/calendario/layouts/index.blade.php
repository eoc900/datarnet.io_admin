<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
    <link href="{{ asset("dashboard_resources/assets/plugins/fullcalendar/css/main.min.css") }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset("dashboard_resources/assets/plugins/input-tags/css/tagsinput.css");}}" rel="stylesheet">
    <link href="{{  asset("dashboard_resources/assets/plugins/fancy-file-uploader/fancy_fileupload.css");}}" rel="stylesheet">
	<link href="{{  asset("dashboard_resources/assets/css/style.css");}}" rel="stylesheet">
</head>
<body>
    @include('general.partials.header')
    @include('general.partials.sidebar')

    <main class="main-wrapper">
        <div class="main-content">
       
            @yield('content')
        </div>
    </main>

    @include('general.partials.scripts')
     <script src="{{  asset("dashboard_resources/assets/plugins/fullcalendar/js/main.min.js");}}"></script>
   <script>
		$(document).ready(function(){

			events = [
				@if(count($data)>0)
					@foreach ($data as $tarea)
						{ 
							extendedProps: {task: "{{ $tarea->id }}"},
							title: "{{ $tarea->titulo }}",
							start: "{{ \Carbon\Carbon::parse($tarea->fecha_inicio)->format('Y-m-d\Th:i:s');}}",
							end: "{{ \Carbon\Carbon::parse($tarea->terminar_en)->format('Y-m-d\Th:i:s');}}",
					@switch($tarea->estado)
						@case("Pendiente")
								className: "bg-danger view_task",
						@break
						@case("En Progreso")
								className: "bg-primary text-white view_task",
						@break
						@case("Completada")
								className: "bg-info view_task",
						@break
						@case("Aprobada")
								className: "bg-success view_task",
						@break
						@case("Reformular")
								className: "bg-warning view_task",
						@break
					@endswitch
							color: "white"
						} 
						@if($data[count($data)-1]!=$tarea)
						{{ "," }}
						@endif
					@endforeach
				@endif
			]

			var calendarEl = document.getElementById('calendar');
			var calendar = new FullCalendar.Calendar(calendarEl, {
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
				},
				initialView: 'dayGridMonth',
				initialDate: '{{ (count($data)>0)?\Carbon\Carbon::parse($data[0]->fecha_inicio)->format('Y-m-d'):\Carbon\Carbon::now(); }}',
				navLinks: true, // can click day/week names to navigate views
				selectable: true,
				nowIndicator: true,
				dayMaxEvents: true, // allow "more" link when too many events
				editable: true,
				selectable: true,
				businessHours: true,
				dayMaxEvents: true, // allow "more" link when too many events
				events: events,
				eventDidMount: function(info) {
            // Access custom properties here
					var task = info.event.extendedProps.task;
					
					info.el.setAttribute('data-task', task);
				

					console.log(info);
				}
			
			});
			calendar.render();

			$(".view_task").click(function(){
				let id = $(this).attr("data-task");
				console.log("this task id is: "+id);
			});
		
		});
		

	</script>
   
    
</body>
</html>