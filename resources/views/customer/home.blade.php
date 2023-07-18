@extends('layouts.customer')

@section('content')
    <div class="container">
        <h1>Hello, {{auth()->user()->name}}</h1>
    </div>
@endsection