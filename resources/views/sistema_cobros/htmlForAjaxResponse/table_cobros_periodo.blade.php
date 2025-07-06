


@if(isset($data))
    <table class="table align-middle mt-5">
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
                {{  ucfirst($data[$i]->{$key}) }}
            </td>
            @endforeach
            
            @if(count($rowActions)>0)
            <td>
                @if(in_array("show",$rowActions))
                <a href="{{ route($routeShow, $data[$i]->{$idKeyName}) }}" class="btn btn-sm btn-primary"><i class="material-icons-outlined">search</i></a>
                @endif
                @if(in_array("edit",$rowActions))
                <a href="{{ route($routeEdit, $data[$i]->{$idKeyName}) }}" class="btn btn-sm btn-outline-info"><i class="material-icons-outlined">edit</i></a>
                @endif

                {{-- @if(in_array("destroy",$rowActions))
                    <a href="{{ route($routeIndex, $data[$i]->{$idKeyName}) }}"
                        class="btn btn-danger btn-sm btn-delete"
                        onclick="event.preventDefault(); document.getElementById( 'delete-form-{{ $data[$i]->{$idKeyName} }}').submit();"> 
                        <i class="material-icons-outlined">delete</i>
                    </a>
                    <form id="delete-form-{{ $data[$i]->{$idKeyName} }}" action="{{ route($routeDestroy, $data[$i]->{$idKeyName}) }}" method="post">  
                        @csrf
                        @method('DELETE') 
                    </form> 
                @endif --}}
            <td>
            @endif
        
        </tr>
        @endfor
    </tbody>
    </table>

    {{ $data->links() }}
@else
    <div class="card">
        <div class="card-body">
            Aún no hay registros guardados
        </div>
    </div>
@endif

