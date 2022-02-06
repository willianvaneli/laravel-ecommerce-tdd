@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Create Product</h1>
    
    @if ($errors->any())
    <div class="alert alert-danger">
        <b>Errors:</b>
        <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('products.store') }}" class="form-group">    
        @csrf
        @include('product.fields')
        
        <button class="btn btn-primary" style="margin-top: 1em">
            Create
        </button>

    </form>
</div>

@endsection