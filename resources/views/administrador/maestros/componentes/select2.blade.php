<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

$(document).ready(function(){

        // There is duplicate rendering error going on
        $('.select2-container:not(:first)').remove();
        $('.select2-maestro').select2({
        placeholder: 'Buscar por nombre',
        ajax:{
            type: "post",
            dataType: "json",
            url: "{{ url('/select2/maestro') }}",
            data: function (params) {
                var query = {
                    search: params.term,
                     _token: '{{csrf_token()}}',
                    type: 'public'
                }

                // Query parameters will be ?search=[term]&type=public
                return query;
            },
            processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                console.log(data);
                    return {
                            results: $.map(data, function (item) {
                                return {
                                    text: "Maestro: "+item.nombre+" "+item.apellido_paterno +" "+item.apellido_materno,
                                    id: item.id,
                                }
                            })
                    }
            }
        }
        });

         // 1. When select2 option is selected we insert the object into the .boxes class
         $('.select2-maestro').on('select2:select', function (e) {
            let id_maestro = e.params.data.id;
            $(".id_master").val(id_maestro);
         
        });


});

</script>