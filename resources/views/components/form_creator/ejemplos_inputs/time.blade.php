@if (isset($show))
     @if (isset($campo["label"]) && isset($campo["name"]))
        {{-- Atributo name --}}
        @php
            $nameAttr = "input[{$tabla}][{$index}][{$campo['name']}]";
        @endphp
        {{-- Atributo name --}}

        <div class="mb-3">
            <label for="" class="form-label">{{ $campo["label"] }}</label>
            <input type="text" name="{{ $nameAttr }}" class="form-control flatpickr-time1 {{ $campo["name"] }}" value="{{ $campo["value"]??'' }}">
        </div>
           @push('jquery')
            <script>
                $(document).ready(function(){
                    flatpickr(".{{ $campo["name"] }}", {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "{{ $campo["formato"] ?? 'H:i' }}",
                        locale: "es"
                    });
                });
            </script>
            @endpush
   
    @else
        <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif
@else
    @if (isset($label) && isset($name))
            <div class="mb-3">
                <label class="form-label">{{ $label }} <span class="text-warning">{{ (isset($opcional))?'(opcional*)':'' }}</span></label>
                <input type="text" class="form-control flatpickr-time1 {{ $name }}" name="{{ $name }}" value="{{ $value??'' }}">
            </div>

            @if(isset($ejemplo))
            <script>
                $(document).ready(function(){
                    flatpickr(".{{ $name }}", {
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "{{ $formato ?? 'H:i' }}",
                        locale: "es"
                    });
                });
            </script>
            @endif

            @push('jquery')
            <script>
                $(document).ready(function(){
                    flatpickr(".{{ $name }}", {
                        altInput: true,
                        dateFormat: "{{ $formato ?? 'H:i' }}",
                        locale: "es"
                    });
                });
            </script>
            @endpush

    @else
        <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif
@endif






