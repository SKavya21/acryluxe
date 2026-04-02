@extends('layouts.app')

@section('content')

<h2>Edit Product</h2>

<form method="POST" action="{{ route('admin.products.update', $product->id) }}">
    @csrf
    @method('PUT')

    <input name="name" value="{{ $product->name }}" class="form-control mb-2">
    <input name="price" value="{{ $product->price }}" class="form-control mb-2">
    <input name="stock" value="{{ $product->stock }}" class="form-control mb-2">
    <input name="color" value="{{ $product->color }}" class="form-control mb-2">
    <input name="size" value="{{ $product->size }}" class="form-control mb-2">
    <input name="image" value="{{ $product->image }}" class="form-control mb-2">

    <button class="btn btn-success">Update</button>
</form>

@endsection