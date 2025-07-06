{{-- ---> NOTA: Las funciones de front-end se encuentran en sistema_cobros.form_creator.layouts.index --}}
@php
    $subcampo = $subcampo ?? true; // si no se pasa, se asume que sí es subcampo (por AJAX)
@endphp
<div class="row configuracion-input shadow border border-light py-5 px-3 mt-3 {{ ($subcampo)?'subcampo':'' }}">
    <button type="button" class="remove-conf-input btn btn-danger"><i class="lni lni-close"></i></button>
     <h5 class="text-dark">Carga de archivo</h5>
      <input type="hidden" name="{{ $subcampo ? 'input' : 'input[]' }}" value="file">
    {{-- ---> datos básicos --}}
    <div class="col-sm-6 mt-3">
        <label for="" class="form-label">Nombre de etiqueta</label>
        <input type="text" placeholder="Ejemplo: Carga de documento" class="form-control" name="{{ $subcampo ? 'label' : 'label[]' }}" value="{{ $input["label"] ?? '' }}">
    </div>
    <div class="col-sm-6 mt-3 mb-5">
        <label for="" class="form-label">Atributo name</label>
        <input type="text" placeholder="fecha_inicio" class="form-control" name="{{ $subcampo ? 'name' : 'name[]' }}" value="{{ $input["name"] ?? '' }}">
    </div>
     {{-- ---> datos básicos --}}

    {{-- Guardar el nombre de carpeta: se debe de guardar dentro de storage/app/carpeta_carga_archivos  --}}
    <div class="col-sm-6 mt-3 mb-5">
        <label for="" class="form-label">Nombre de la carpeta</label>
        <input type="text" name="{{ $subcampo ? 'storage_directory' : 'storage_directory[]' }}" class="form-control storage_directory">
    </div>

    <div class="col-sm-6 mt-3 mb-5">
        <label for="maxBytes" class="form-label">Máximo permitido (en MB):</label>
        <input type="number" id="maxBytes" name="{{ $subcampo ? 'megabytes' : 'megabytes[]' }}" value="5" class="form-control file_size">
    </div>


    {{-- Tipos de archivos --}}
    <div class="col-sm-6 mt-3 mb-5">
        <label for="" class="form-label">Selecciona los tipos de archivos permitidos</label>
        <!-- Documentos -->
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".pdf" id="fileTypePdf">
        <label class="form-check-label" for="fileTypePdf">PDF (.pdf)</label>
        </div>
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".doc,.docx" id="fileTypeDoc">
        <label class="form-check-label" for="fileTypeDoc">Word (.doc, .docx)</label>
        </div>
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".xls,.xlsx" id="fileTypeXls">
        <label class="form-check-label" for="fileTypeXls">Excel (.xls, .xlsx)</label>
        </div>
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".ppt,.pptx" id="fileTypePpt">
        <label class="form-check-label" for="fileTypePpt">PowerPoint (.ppt, .pptx)</label>
        </div>
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".txt" id="fileTypeTxt">
        <label class="form-check-label" for="fileTypeTxt">Texto (.txt)</label>
        </div>

        <!-- Imágenes -->
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".jpg,.jpeg" id="fileTypeJpg">
        <label class="form-check-label" for="fileTypeJpg">Imagen JPG (.jpg, .jpeg)</label>
        </div>
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".png" id="fileTypePng">
        <label class="form-check-label" for="fileTypePng">Imagen PNG (.png)</label>
        </div>
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".gif" id="fileTypeGif">
        <label class="form-check-label" for="fileTypeGif">GIF (.gif)</label>
        </div>

        <!-- Audio -->
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".mp3" id="fileTypeMp3">
        <label class="form-check-label" for="fileTypeMp3">Audio MP3 (.mp3)</label>
        </div>
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".wav" id="fileTypeWav">
        <label class="form-check-label" for="fileTypeWav">Audio WAV (.wav)</label>
        </div>

        <!-- Video -->
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".mp4" id="fileTypeMp4">
        <label class="form-check-label" for="fileTypeMp4">Video MP4 (.mp4)</label>
        </div>
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".mov" id="fileTypeMov">
        <label class="form-check-label" for="fileTypeMov">Video MOV (.mov)</label>
        </div>

        <!-- Comprimidos -->
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".zip" id="fileTypeZip">
        <label class="form-check-label" for="fileTypeZip">Archivo ZIP (.zip)</label>
        </div>
        <div class="form-check">
        <input class="form-check-input file_type" type="checkbox" name="{{ $subcampo ? 'file_types': 'file_types[]' }}" value=".rar" id="fileTypeRar">
        <label class="form-check-label" for="fileTypeRar">Archivo RAR (.rar)</label>
        </div>
    </div>



    {{--VALIDACIONES: Aquí se pondrá por medio de frontend las validaciones --}}
    <div class="form-check form-switch mt-5 float-end">
            <input class="form-check-input validacion_activada" type="checkbox" id="" name="validacion_activada[{{ $i }}]" value="true">
            <label class="form-check-label" for="">Activar validación de campo</label>
    </div>    
    <div class="contenedor-validaciones" data-index="{{ $i }}"></div>{{-- Aquí hacemos append del elemento .caja-index --}}
    {{--VALIDACIONES: Aquí se pondrá por medio de frontend las validaciones --}}


    {{-- Previsualización  --}}
    @include('components.form_creator.previsualizacion')
    {{-- Previsualización  --}}
    
</div>