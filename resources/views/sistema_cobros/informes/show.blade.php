@extends('sistema_cobros.informes.layouts.show')
@section("content")
@include('components.sistema_cobros.response')


<div class="card">
    <div class="card-header pt-3">
        <h5>{{ $titulo ?? '' }}</h5>
    </div>

     <div class="card-body mx-5 p-4 mb-5">
         <div class="row mt-3 mb-5">
         @foreach ($filtros as $index=>$filtro)            
                    @if ($index=="text")
                        @if($filtro["mode"]==="select2")
                        @include("components.form_creator.ejemplos_inputs.select2",$filtro)
                        @endif
                    @endif
                    @if ($index=="date")
                       @include("sistema_cobros.informes.componentes.show.date_filter",[
                        "default_end"=>$default_end,
                        "default_start"=>$default_start])
                    @endif
              
        @endforeach
        <div class="col-12"> <button type="filtrar" id="filtrar" class="btn btn-primary float-end">Filtrar</button></div>
        </div>
        
   

    @foreach ($secciones as $seccion)
        @switch($seccion["tipo"])
            @case("tabla")
                @include('sistema_cobros.informes.componentes.show.tabla_dinamica',["registros"=>$seccion["resultados"]])
            @break
            @case("tarjeta")
                @include('sistema_cobros.informes.componentes.show.tarjeta_dinamica',["registros"=>$seccion["resultados"],"tarjeta_titulo"=>$seccion["tarjeta_titulo"]])
            @break
            @case("grafica")
            @include('sistema_cobros.informes.componentes.show.grafica_dinamica', [
                'seccion' => $seccion
            ])

            @break
        @default
        @endswitch
    @endforeach
   

     </div>
</div>





@endsection

@push('filtros_funciones_show')
<script>
eventoActivarFiltrado();
function eventoActivarFiltrado() {
    $('#filtrar').on('click', function (e) {
        e.preventDefault();

        const fechaInicio = $('#filtro_fecha_inicio').val();
        const fechaFinaliza = $('#filtro_fecha_finaliza').val();
        const textoBusqueda = $('.select2-components').val();

        const params = new URLSearchParams();

        if (fechaInicio) params.append('inicio', fechaInicio);
        if (fechaFinaliza) params.append('finaliza', fechaFinaliza);
        if (textoBusqueda) params.append('texto', textoBusqueda);

        const urlActual = window.location.pathname;
        const idInforme = urlActual.split('/').pop();

        window.location.href = `/informes/${idInforme}?` + params.toString();
    });
}
</script>
@endpush
