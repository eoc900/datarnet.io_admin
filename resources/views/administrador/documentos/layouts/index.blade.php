<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
    <link href="{{ asset("dashboard_resources/assets/plugins/fullcalendar/css/main.min.css") }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset("dashboard_resources/assets/plugins/input-tags/css/tagsinput.css");}}" rel="stylesheet">
    <link href="{{  asset("dashboard_resources/assets/plugins/fancy-file-uploader/fancy_fileupload.css");}}" rel="stylesheet">
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
    {{-- <script src="{{ asset("dashboard_resources/assets/plugins/fancy-file-uploader/jquery.fileupload.js");}}"></script> --}}
    <script src="{{ asset("dashboard_resources/assets/plugins/fancy-file-uploader/jquery.fancy-fileupload.js");}}"></script>
    <script>
        $(document).ready(function(){
            $('#fancy-file-upload').FancyFileUpload({
			params: {
				action: 'fileuploader'
			},
			maxfilesize: 1000000
		    });
        });
	</script>
   
    
</body>
</html>