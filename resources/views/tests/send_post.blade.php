@extends('tests.layouts.index')
@section("content")

 @include('general.partials.alertsTopSection')
  <form action="{{ url('/webhooks/mailgun') }}" method="post" enctype="multipart/form-data">
    <input type="text" name="sender" placeholder="sender">
    <input type="text" name="sender" placeholder="subject">
    <input type="text" name="sender" placeholder="timestamp">
    <input type="text" name="sender" placeholder="body-plaine">
     <input type="text" name="sender" placeholder="body-html">
    <button type="submit">Enviar</button>
</form>

@endsection