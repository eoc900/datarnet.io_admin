@extends('sistema_cobros.layouts.index')
@section("content")

<h3 class="text-center pb-5 pt-5">Concepto: {{ $datos["concepto"]->nombre }} <b>({{ $datos["concepto"]->identificador }})</b></h3>

<div class="card w-100 rounded-4">
<div class="card-body">
<div class="row">
    <div class="col-12 mt-3">
        <ol>
            @foreach ($datos["costos_asociados"] as $costo)
                <li>{{ $costo->periodo }} | {{ $costo->concepto }} | ${{ number_format($costo->costo,2) }}</li>
            @endforeach
        </ol>
      
    </div>
</div>
</div>
</div>



@endsection