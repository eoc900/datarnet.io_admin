<script>
$(document).ready(function(){

        @if(request("search") && request("search")!="")
            $("#buscarInfoTabla").val('{{ request("search") }}');
        @endif

       
    $("#{{ $idBotonBuscar }}").click(function(e){
        e.preventDefault();
        $("#formSearch").submit();
    });
});
</script>