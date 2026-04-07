@extends('layouts.app')

@section('content')

<h2>Manage Products</h2>

<a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">
    Add Product
</a>

<table class="table">
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Image</th>
        <th>Action</th>
    </tr>

    @foreach($products as $product)
    <tr>
        <td>{{ $product->name }}</td>
        <td>₹{{ $product->price }}</td>
        <td>{{ $product->stock }}</td>
         @if($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" width="100" class="mb-2">
    @endif

    <input type="file" name="image" class="form-control mb-2">
        <td>

            <a href="{{ route('admin.products.edit', $product->id) }}" 
               class="btn btn-warning btn-sm">
               Edit
            </a>

            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                  method="POST" 
                  style="display:inline;">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                    Delete
                </button>
            </form>

        </td>
    </tr>
    @endforeach

</table>

@endsection