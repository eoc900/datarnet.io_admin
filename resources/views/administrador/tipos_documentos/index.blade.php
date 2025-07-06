@extends('administrador.tipos_documentos.layouts.dynamic_table')
@section("content")
 
    <!--breadcrumb-->
        

        <div class="dynamic_table">
          @include('general.tables.simple_table', [
              'data' => $data,
              "columns"=>$columns,
              "keys"=>$keys,
              "rowCheckbox"=>$rowCheckbox,
              "idKeyName"=>$idKeyName,
              "rowActions"=>$rowActions,
              "routeDestroy"=>$routeDestroy,
              "routeShow"=>$routeShow,
              "routeEdit"=>$routeEdit,
              "routeIndex"=>$routeIndex
              ])
        </div>

@endsection