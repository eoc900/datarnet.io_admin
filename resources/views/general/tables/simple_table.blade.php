
@if(isset($data) && count($data)>0)
<div class="card">
    <div class="card-body pt-4">
        <table class="table align-middle">
<thead class="table-light">     
<tr>
    @if($rowCheckbox)
    <th><input class="form-check-input" type="checkbox" data-selected="all"></th>
    @endif

    @if(isset($columns))
        @foreach($columns as $column)
                <th>{{ $column }}</th>
        @endforeach
    @endif
    @if(count($rowActions)>0)
        <th>Acciones</th>
    @endif
</tr>
</thead>
<tbody>
    @for($i = 0; $i < count($data); $i++)
        <tr>
        @if($rowCheckbox)
            <th><input class="form-check-input" type="checkbox" data-selected="all" value="{{ $data[$i]->{$idKeyName} }}"></th>
        @endif
        @foreach($keys as $key)
        <td>
            @if($key=="estado" && $indicadores)
                 <button type="button" class="btn {{ (isset($botones[$data[$i]->{$key}]))? $botones[$data[$i]->{$key}] : "btn-outline-default" }} px-5">{{  ucfirst($data[$i]->{$key}) }}</button>
            @elseif($key=="activo" && $indicadores)
                <button type="button" class="btn {{ (isset($botones[$data[$i]->{$key}]))? $botones[$data[$i]->{$key}] : "btn-outline-default" }} px-5">{{ ($data[$i]->{$key}==1)?"Activo":"Descativado"; }}</button>
            @elseif ($key=="costo")
                ${{  $data[$i]->{$key} }}
            @else
                 {{  ucfirst($data[$i]->{$key}) }}
            @endif
        </td>
        @endforeach
        
        @if(count($rowActions)>0)
        <td>
            @if(in_array("show",$rowActions))
            <a href="{{ route($routeShow, $data[$i]->{$idKeyName}) }}" class="btn btn-sm btn-primary"><i class="material-icons-outlined">search</i></a>
            @endif
            @if(in_array("edit",$rowActions) && $listaEdicion!="")
            <a href="{{ route($routeEdit, [$listaEdicion,$data[$i]->{$idKeyName}]) }}" class="btn btn-sm btn-outline-info"><i class="material-icons-outlined">edit</i></a>
            @endif
            @if(in_array("edit",$rowActions) && $listaEdicion=="")
            <a href="{{ route($routeEdit, $data[$i]->{$idKeyName}) }}" class="btn btn-sm btn-outline-info"><i class="material-icons-outlined">edit</i></a>
            @endif

            @if(in_array("destroy",$rowActions))
                <a href="{{ route($routeIndex, $data[$i]->{$idKeyName}) }}"
                    class="btn btn-danger btn-sm btn-delete"
                    onclick="event.preventDefault(); document.getElementById( 'delete-form-{{ $data[$i]->{$idKeyName} }}').submit();"> 
                    <i class="material-icons-outlined">delete</i>
                </a>
                <form id="delete-form-{{ $data[$i]->{$idKeyName} }}" action="{{ route($routeDestroy, $data[$i]->{$idKeyName}) }}" method="post">  
                    @csrf
                    @method('DELETE') 
                </form> 
            @endif
        <td>

        @if ($qr_code_url)
            <td>
                  <a href="{{ route('generar.qr',$data[$i]->slug) }}"
                    class="btn btn-dark btn-sm">
                    <i class="fadeIn animated bx bx-area"></i></a>
                </a>
            </td>
        @endif
        @endif
    
    </tr>
    @endfor
</tbody>
</table>
    </div>
</div>
{{ $data->links() }}
@else

<div class="card">
    <div class="card-body">
        Aún no hay registros guardados
    </div>
</div>
@endif