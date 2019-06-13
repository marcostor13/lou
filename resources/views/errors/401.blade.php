@extends('layouts.app')

@section('content')

    <div class="container">
        <h1 class="text-center">{{ $exception->getMessage() }}</h1>
    </div>
    
@endsection