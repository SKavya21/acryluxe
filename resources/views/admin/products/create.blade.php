@extends('layouts.app')

@section('content')

<h2>Add Product</h2>

<form method="POST" action="{{ route('admin.products.store') }}">
    @csrf

    <input name="name" placeholder="Name" class="form-control mb-2">
    <input name="price" placeholder="Price" class="form-control mb-2">
    <input name="stock" placeholder="Stock" class="form-control mb-2">
    <input name="color" placeholder="Color" class="form-control mb-2">
    <input name="size" placeholder="Size" class="form-control mb-2">
    <input name="image" placeholder="Image URL" class="form-control mb-2">
    <input type="file" name="image" class="form-control mb-2">

    <button class="btn btn-primary">Save</button>
</form>

@endsection