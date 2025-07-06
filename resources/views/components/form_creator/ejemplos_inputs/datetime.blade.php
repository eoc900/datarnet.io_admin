@if (isset($show))
    @if (isset($campo["label"]) && isset($campo["name"]))
            {{-- Atributo name --}}
            @php
                $nameAttr = "input[{$tabla}][{$index}][{$campo['name']}]";
            @endphp
            {{-- Atributo name --}}
            <div class="mb-3">
                <label class="form-label">{{ $campo["label"] }}</label>
                <input type="text" class="form-control flatpickr-datetime {{ $campo["name"] }}" name="{{ $nameAttr }}" value="{{ $campo["value"]??'' }}" data-formato="{{ $campo['formato'] ?? 'Y-m-d H:i' }}">
            </div>

           
            @push('jquery')
                <script>
                    $(document).ready(function(){
                            $(".{{ $campo["name"] }}").flatpickr({
                                    altInput: true,
                                    enableTime: true,
                                    dateFormat: "{{ $campo["formato"]  }}",
                                    locale: "es" // Establecer el idioma español
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
                <label class="form-label">{{ $label }}</label>
                <input type="text" class="form-control flatpickr-datetime {{ $name }}" name="{{ $name }}" value="{{ $value??'' }}" data-formato="{{ $campo['formato'] ?? 'Y-m-d H:i' }}">
            </div>

            @if(isset($ejemplo))
                <script>
                    $(document).ready(function(){
                            $(".{{ $name }}").flatpickr({
                                    altInput: true,
                                    enableTime: true,
                                    dateFormat: "{{ $formato }}",
                                    locale: "es" // Establecer el idioma español
                            });
                    });
                </script>
            @endif
            @push('jquery')
                <script>
                    $(document).ready(function(){
                            $(".{{ $name }}").flatpickr({
                                    altInput: true,
                                    enableTime: true,
                                    dateFormat: "{{ $formato }}",
                                    locale: "es" // Establecer el idioma español
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


