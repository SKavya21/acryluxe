@extends('admin.layout')

@section('title', 'Products')
@section('section', 'Products')

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
        <td>{{ $product->totalStock() }}</td>
        <td>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" width="100" alt="{{ $product->name }}">
            @else
                <span class="text-muted">No image</span>
            @endif
        </td>
        <td>

            <a href="{{ route('admin.products.edit', $product->id) }}" 
               class="btn btn-warning btn-sm">
               Edit
            </a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}" 
                  method="POST" 
                                    class="delete-product-form"
                  style="display:inline;">
                @csrf
                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                    Delete
                </button>
            </form>

        </td>
    </tr>
    @endforeach

</table>

<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="deleteProductModalLabel">Delete product?</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Do you really want to delete the product?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmProductDelete">Delete product</button>
            </div>
        </div>
    </div>
</div>

<script>
    const deleteProductModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
    const confirmProductDelete = document.getElementById('confirmProductDelete');
    let pendingProductDeleteForm = null;

    document.querySelectorAll('.delete-product-form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            event.preventDefault();
            pendingProductDeleteForm = form;
            deleteProductModal.show();
        });
    });

    confirmProductDelete.addEventListener('click', () => {
        if (!pendingProductDeleteForm) return;

        pendingProductDeleteForm.submit();
    });
</script>

@endsection