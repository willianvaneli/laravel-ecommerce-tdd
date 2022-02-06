@extends('layouts.app')

@section('content')

<div class="container">
    <h1>All Products</h1>
    <div class="row">
        <div class="col-md-4">
            <label>Name</label>
        </div>
        <div class="col-md-4">
            <label>Price (in cents)</label>
        </div>
    </div>
    
    @foreach ($products->all() as $product)
    <div class="row">
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" value="{{ !empty($product) ? $product->name : old('name')}}">
        </div>
        <div class="col-md-4">
            <input type="number" name="price" min="0" step="1" class="form-control" value="{{ !empty($product) ? $product->price : old('price')}}">
        </div>
        <div class="col-md-1">
            <a href={{ 'products/' . $product->id  }} class="btn btn-success" style="width:100%">Show</a>
        </div>
        <div class="col-md-1">
            <a href={{ 'products/' . $product->id . '/edit' }} class="btn btn-warning" style="width:100%">Edit</a>
        </div>
        <div class="col-md-1">
            <a href="terrenos/ class="btn btn-danger" style="width:100%">Delete</a>
        </div>
        <p>
    </div>
    @endforeach

</div>

@endsection
