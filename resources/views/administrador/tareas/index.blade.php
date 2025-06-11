@extends('administrador.tareas.layouts.dynamic_table')
@section("content")
    @include('general.partials.alertsTopSection')

    <!--breadcrumb-->
        <div class="dynamic_table">
          @include('general.tables.simple_table', [
              'data' => $data,
              "columns"=>$columns,
              "keys"=>$keys,
              "rowCheckbox"=>$rowCheckbox,
              "indicadores"=>(isset($indicadores))? $indicadores : false,
              "botones"=>(isset($botones))? $botones : array(),
              "idKeyName"=>$idKeyName,
              "rowActions"=>$rowActions,
              "routeDestroy"=>$routeDestroy,
              "routeShow"=>$routeShow,
              "routeEdit"=>$routeEdit,
              "routeIndex"=>$routeIndex,
              "botones"
              ])
        </div>

@endsection