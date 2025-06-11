<div class="col-sm-{{ $valor_col }} seccion" data-seccion="{{ $id }}">
    <div class="card rounded shadow border p-3 h-auto">
        {{-- Contenido de configuracion --}}
        <h5>Configurar tabla</h5>
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
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                        </tr>
                    </tbody>
                    </table>
                </div>
    </div>
</div>