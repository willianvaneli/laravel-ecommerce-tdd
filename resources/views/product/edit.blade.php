@extends('layouts.app')

@section('content')

<div class="container">
    <h1>Edit Product</h1>
    
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

    <form method="PUT" action="{{ route('products.update', $product->id) }}" class="form-group">
        @method('PUT')
        @csrf
        @include('product.fields')
        
        <button type="submit" class="btn btn-primary" style="margin-top: 1em">
            Update
        </button>

    </form>
</div>

@endsection