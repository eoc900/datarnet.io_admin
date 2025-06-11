<script>
$(document).ready(function(){

       var renderSectionId = $('#{{ $renderSectionID }}');

       function ajaxCall_{{ $ajaxCallSuffix }}(id_cuenta="",params={}){

         $.ajax({
            url: "{{ url($routeAjaxName) }}",
            method: 'POST',
            data: {
                _token:'{{csrf_token()}}',
                id_cuenta: id_cuenta,
                params: params
            },
            success: function(data) {
                console.log(data);
                $('#{{ $renderSectionID }}').html("");
                $('#{{ $renderSectionID }}').html(data);
            }
        });

       }

       ajaxCall_{{ $ajaxCallSuffix }}("{{ $idCuenta }}");

       $('#{{ $classOnChange }}').change(function(){
            let id = $(this).val();
            ajaxCall_{{ $ajaxCallSuffix }}(id);
       });
});

</script>