@extends('landing_page.layouts.index')
@section("content")
 
@php
    $ruta_banner = $ruta_banner 
        ? Storage::url($ruta_banner) 
        : asset('dashboard_resources/imagenes/banner-default.jpg');
@endphp


   <!-- undergraduate breadcrumb start -->
      <section class="tp-breadcrumb__area pt-160 pb-150 p-relative z-index-1 fix">
      <div class="tp-breadcrumb__bg"  data-background="{{ $ruta_banner }}"><div class="bg-overlay"></div>
         
      <div class="container">
         <div class="row align-items-center">
            <div class="col-sm-12">
               <div class="tp-breadcrumb__content">
                  <h3 class="tp-breadcrumb__title color pt-50">{{ $titulo ?? '' }}</h3>
               </div>
            </div>
         </div>
      </div>
      </div>
      </section>
      <!-- undergraduate breadcrumb end -->



         <!-- hero-area-start -->
<section class="tp-hero-area">
<div class="container pt-5 pb-105">

<div class="card mt-5">
    <div class="card-header pt-30">
        <p>{{ $descripcion ?? '' }}</p>
    </div>
    <div class="card-body mx-5">
        @include('components.sistema_cobros.response')
        <form class="row" method="post" action="{{ route('ruta_publica') }}" enctype="multipart/form-data">
            @csrf
            <x-lista-mensajes/>
            <input type="hidden" name="identificador_action" value="{{ $hidden_identifier ?? '' }}">
            <input type="hidden" name="nombre_documento" value="{{ $nombre_documento ?? '' }}">
            <input type="hidden" name="liga" value="{{ $liga ?? '' }}">
            
       
            {{-- USO: ITERACIÓN Para poner cada componente de formulario --}}
            @foreach ($inputs as $input)
                <div class="col-sm-6 mt-3">
                @if ($input["type"]=="text")
                    @include("components.form_creator.ejemplos_inputs.text",$input)
                @endif
                @if ($input["type"]=="date")
                    @include("components.form_creator.ejemplos_inputs.date",$input)
                @endif
                @if ($input["type"]=="datetime")
                    @include("components.form_creator.ejemplos_inputs.datetime",$input)
                @endif
                @if ($input["type"]=="select2")
                    @include("components.form_creator.ejemplos_inputs.select2",$input)
                @endif
                @if ($input["type"]=="dropdown")
                    @include("components.form_creator.ejemplos_inputs.dropdown",$input)
                @endif
                @if ($input["type"]=="radio")
                    @include("components.form_creator.ejemplos_inputs.radio",$input)
                @endif
                @if ($input["type"]=="email")
                    @include("components.form_creator.ejemplos_inputs.email",$input)
                @endif
                @if ($input["type"]=="file")
                    @include("components.form_creator.ejemplos_inputs.file",$input)
                @endif
                @if ($input["type"]=="checkbox")
                    @include("components.form_creator.ejemplos_inputs.checkbox",$input)
                @endif
                </div>
            @endforeach
             {{-- USO:  Para poner cada componente de formulario --}}
          


            <x-boton 
                nombre_boton="Insertar formulario" 
                type="submit" 
                classes="btn-submit btn btn-success float-end" 
                parentClass="col-12 pt-5 float-end"
            />
        </form>
    </div>
</div>
</div>
</section>




@endsection

