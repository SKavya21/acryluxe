@extends('admin.layout')

@section('title', 'Add product')
@section('section', 'Products')

@section('content')

<div class="d-flex justify-content-between align-items-end mb-4">
    <div><p class="admin-eyebrow">Catalog</p><h1 class="admin-title">Add product</h1><p class="admin-muted mb-0">Create a product with a flexible image gallery.</p></div>
    <a href="{{ route('admin.products.index') }}" class="admin-button secondary">Back to products</a>
</div>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="admin-panel p-4">
    @csrf

    <div class="row g-3">
        <div class="col-md-8"><label class="form-label" for="name">Product name</label><input id="name" name="name" class="form-control" value="{{ old('name') }}" required></div>
        <div class="col-md-4"><label class="form-label" for="price">Price (INR)</label><input id="price" name="price" type="number" min="0" step="0.01" class="form-control" value="{{ old('price') }}" required></div>
        <div class="col-12"><label class="form-label" for="description">Description</label><textarea id="description" name="description" rows="4" class="form-control">{{ old('description') }}</textarea></div>
        <div class="col-md-4"><label class="form-label" for="color">Color</label><input id="color" name="color" class="form-control" value="{{ old('color') }}"></div>
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <label class="form-label mb-0">Sizes and quantities</label>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="add-size"><span aria-hidden="true">+</span><span class="visually-hidden">Add size</span></button>
            </div>
            <div id="size-fields" class="d-grid gap-2 mt-2">
                <div class="row g-2 size-row">
                    <div class="col"><input name="sizes[0][size]" class="form-control" placeholder="Size 1" value="{{ old('sizes.0.size') }}"></div>
                    <div class="col"><input name="sizes[0][quantity]" type="number" min="0" class="form-control" placeholder="Quantity" value="{{ old('sizes.0.quantity') }}"></div>
                </div>
            </div>
        </div>
        <div class="col-12"><label class="form-label" for="images">Product photos</label><input id="images" type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple class="form-control"><div id="image-preview" class="row g-2 mt-2"></div><div class="form-text">Select multiple JPG, PNG, or WebP photos. Each file can be up to 2 MB.</div></div>
    </div>

    <button class="admin-button mt-4" type="submit">Save product</button>
</form>

<script>
    const sizeFields = document.getElementById('size-fields');
    document.getElementById('add-size').addEventListener('click', () => {
        const index = sizeFields.querySelectorAll('.size-row').length;
        sizeFields.insertAdjacentHTML('beforeend', `<div class="row g-2 size-row"><div class="col"><input name="sizes[${index}][size]" class="form-control" placeholder="Size ${index + 1}"></div><div class="col"><input name="sizes[${index}][quantity]" type="number" min="0" class="form-control" placeholder="Quantity"></div></div>`);
    });

    document.getElementById('images').addEventListener('change', (event) => {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        Array.from(event.target.files).forEach((file) => {
            const url = URL.createObjectURL(file);
            preview.insertAdjacentHTML('beforeend', `<div class="col-6 col-md-3"><img src="${url}" alt="${file.name}" class="img-fluid rounded border" style="aspect-ratio:1;object-fit:cover"><small class="d-block text-muted text-truncate">${file.name}</small></div>`);
        });
    });
</script>

@endsection