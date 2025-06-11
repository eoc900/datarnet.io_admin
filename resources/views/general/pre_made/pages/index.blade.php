@extends('general.pre_made.layouts.index')
@section("content")

<br>
<br>
<br>
<h1>{{ (Auth::user()->hasRole('Guest'))?"Has role":"Nothing" }}</h1>


@endsection