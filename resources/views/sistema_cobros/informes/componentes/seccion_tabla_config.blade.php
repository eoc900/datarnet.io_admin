<div class="col-sm-{{ $valor_col }} seccion position-relative" data-seccion="{{ $id }}">
    <div class="card rounded shadow border p-3 h-auto scroll-x position-relative">
        
        {{-- Botón eliminar sección --}}
        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 eliminar-seccion"
                data-id="{{ $id }}" title="Eliminar sección">
            <i class="bi bi-trash"></i>
        </button>

        {{-- Zona clickeable con overlay --}}
        <div class="seccion-body position-relative">
            
            {{-- Overlay que se muestra al hacer hover --}}
            <div class="seccion-overlay" data-seccion="{{ $id }}">
                <i class="bi bi-gear-fill text-white fs-2 position-absolute top-50 start-50 translate-middle"></i>
            </div>

            <h5>Configurar tabla</h5>
            <hr>

            <div class="card-body">
                <h5 class="card-title">Título de la tabla</h5>
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><th scope="row">1</th><td>Mark</td><td>Otto</td><td>@mdo</td></tr>
                        <tr><th scope="row">2</th><td>Jacob</td><td>Thornton</td><td>@fat</td></tr>
                        <tr><th scope="row">3</th><td colspan="2">Larry the Bird</td><td>@twitter</td></tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
