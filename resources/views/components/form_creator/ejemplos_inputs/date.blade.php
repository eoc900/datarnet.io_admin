@if (isset($show))
    @if (isset($campo["label"]) && isset($campo["name"]))
        {{-- Atributo name --}}
        @php
            $nameAttr = "input[{$tabla}][{$index}][{$campo['name']}]";
        @endphp
        {{-- Atributo name --}}

                <div class="mb-3">
                    <label class="form-label">{{ $campo["label"] }} <span class="text-warning">{{ (isset($campo["opcional"]))?'(opcional*)':'' }}</span></label>
                    <input type="text" class="form-control flatpickr-date {{ $campo["name"] }}" name="{{ $nameAttr }}" value="{{ $campo["value"]??'' }}">
                </div>            
                @push('jquery')
                <script>
                    $(document).ready(function(){
                        flatpickr(".{{ $campo["name"] }}", {
                            altInput: true,
                            dateFormat: "{{ $campo["formato"] ?? 'Y-m-d' }}",
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
                <input type="text" class="form-control flatpickr-date {{ $name }}" name="{{ $name }}" value="{{ $value??'' }}">
            </div>

            @if(isset($ejemplo))
            <script>
                $(document).ready(function(){
                    flatpickr(".{{ $name }}", {
                        altInput: true,
                        dateFormat: "{{ $formato ?? 'Y-m-d' }}",
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
                        dateFormat: "{{ $formato ?? 'Y-m-d' }}",
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


