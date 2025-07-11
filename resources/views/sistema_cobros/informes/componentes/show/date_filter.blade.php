
<div class="row">
<div class="col-sm-6 mt-3 mb-5">
    <label for="" class="form-label">Fecha inicio </label>
    <input type="text" class="form-control inicia data-param" name="inicio" value="{{ $default_start }}" id="filtro_fecha_inicio" data-param="fecha-inicio">
</div>




<div class="col-sm-6 mt-3 mb-5">
    <label for="" class="form-label">Finalizar</label>
    <input type="text" class="form-control finaliza data-param" name="finaliza" value="{{ $default_end }}" id="filtro_fecha_finaliza" data-param="fecha-finaliza">
</div>
</div>


@push('funciones_show_date_filter')
    <script>
        function activarCalendarioInicio(){
            $(".inicia").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d",
            });        
        }
        function activarCalendarioFinaliza(){
            $(".finaliza").flatpickr({
                enableTime: true,
                dateFormat: "Y-m-d",
            });
        }
        $(document).ready(function(){
         
                activarCalendarioInicio();        
                activarCalendarioFinaliza();
  
        })
    </script>
@endpush