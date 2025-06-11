 $('#{{ $idSelect2 }}').select2({
        placeholder: 'Select an option',
       
      
        ajax:{
            type: "post",
            dataType: "json",
            url: "{{ url($select2) }}",
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
                                  {{ $slot }}
                                    
                                }
                            })
                    }
            }
        }
});



