
@if (isset($carpetas))
    <table>
    <thead>
    <tr>
      <th scope="col">Carpeta</th>
      <th scope="col"></th>
    </tr>
  </thead>
    <tbody>
        @foreach ($carpetas as $carpeta)
            <th>{{ $carpeta }}</th>
            <th><button type="button" class="Ir" data-carpeta="{{ $carpeta }}">{{ $carpeta }}</button></th>
        @endforeach
    </tbody>
    </table>
@endif

