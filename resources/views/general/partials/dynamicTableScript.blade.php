<script src="{{ asset("dashboard_resources/assets/plugins/input-tags/js/tagsinput.js"); }}"></script>
<script>
$(document).ready(function(){
    function clearFilterAndAddValues(){
        
      
        
        @if(request("filter") && request("filter")!="")
            $(".bootstrap-tagsinput").children()[0].remove();
            $(".tagsinput-values").val("");
            let html = '<span class="badge bg-primary">{{ request("filter") }}<span data-role="remove"></span></span>';
            $(".bootstrap-tagsinput").prepend(html);
            $(".tagsinput-values").val("{{ request("filter") }}");
            $(".bootstrap-tagsinput").find('[data-role="remove"]').click(function(){
                $(this).parent().remove();
                $(".tagsinput-values").val("");
            });
        @endif

        @if(request("search") && request("search")!="")
            $("#dynamic_search").val('{{ request("search") }}');
        @endif

        return false;
        
        
    }

    clearFilterAndAddValues();


    $(".filtro").click(function(){
        let value = $(this).attr("data-filtro");
        let html = '<span class="badge bg-primary">'+value+'<span data-role="remove"></span></span>';
        $(".tagsinput-values").val("");
        
        $(".bootstrap-tagsinput").children()[0].remove();
        $(".tagsinput-values").val(value);
        $(".bootstrap-tagsinput").prepend(html);
        
        $(".bootstrap-tagsinput").find('[data-role="remove"]').click(function(){
            $(this).parent().remove();
            $(".tagsinput-values").val("");
        });
    });

    function fetchData(searchFor,page = 1, filter="") {
        $.ajax({
            url: "{{ url($ajaxRenderRoute) }}",
            method: 'GET',
            data: {
                search: searchFor,
                page: page,
                filter: filter
            },
            success: function(data) {
                $("{{ $reRenderSection }}").html("");
                $("{{ $reRenderSection }}").html(data);
            }
        });
    }

    $("#testAjax").click(function(){
        let searchFor = $("#dynamic_search").val();
        let filtro = ($(".tagsinput-values").val()!==undefined)?$(".tagsinput-values").val():"";
        console.log(searchFor);
        console.log(filtro);
       
        fetchData(searchFor, 1,filtro);
    });
});
</script>