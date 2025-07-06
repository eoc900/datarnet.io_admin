<x-search :urlRoute="$urlRoute" :placeholder="$confTabla['placeholder']" :idInputSearch="$confTabla['idSearch']" :idBotonBuscar="$confTabla['idBotonBuscar']" 
:botonBuscar="$confTabla['botonBuscar']" :filtrosBusqueda="$confTabla['filtrosBusqueda']" :tituloTabla="$confTabla['tituloTabla']" :value="$confTabla['valueSearch']"/>

 @include('general.partials.alertsTopSection')

    <!--breadcrumb-->
        <div class="dynamic_table">
          @include('general.tables.simple_table', [
              'data' => $confTabla['data'],
              "columns"=>$confTabla['columns'],
              "keys"=>$confTabla['keys'],
              "rowCheckbox"=>$confTabla['rowCheckbox'],
              "indicadores"=>(isset($confTabla['indicadores']))? $confTabla['indicadores'] : false,
              "botones"=>(isset($confTabla['botones']))? $confTabla['botones'] : array(),
              "idKeyName"=>$confTabla['idKeyName'],
              "rowActions"=>$confTabla['rowActions'],
              "routeDestroy"=>$confTabla['routeDestroy'],
              "routeShow"=>$confTabla['routeShow'],
              "routeEdit"=>$confTabla['routeEdit'],
              "listaEdicion"=>((isset($confTabla['listaEdicion']))?$confTabla['listaEdicion']:""), // referente a un método ListadoFormularios
              "routeIndex"=>$confTabla['routeIndex'],
              "botones"=>$confTabla['botones'],
              "qr_code_url"=>$confTabla['qr_code_url']??''
              ])
        </div>