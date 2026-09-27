@extends('admin.layout')

@section('title', 'Edit product')
@section('section', 'Products')

@section('content')

<div class="d-flex justify-content-between align-items-end mb-4">
    <div><p class="admin-eyebrow">Catalog</p><h1 class="admin-title">Edit product</h1><p class="admin-muted mb-0">Update details or remove photos from the product gallery.</p></div>
    <a href="{{ route('admin.products.index') }}" class="admin-button secondary">Back to products</a>
</div>

<form id="product-edit-form" method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" class="admin-panel p-4">
    @csrf
    @method('PUT')

    <div class="row g-3">
        <div class="col-md-8"><label class="form-label" for="name">Product name</label><input id="name" name="name" value="{{ old('name', $product->name) }}" class="form-control" required></div>
        <div class="col-md-4"><label class="form-label" for="price">Price (INR)</label><input id="price" name="price" type="number" min="0" step="0.01" value="{{ old('price', $product->price) }}" class="form-control" required></div>
        <div class="col-12"><label class="form-label" for="description">Description</label><textarea id="description" name="description" rows="4" class="form-control">{{ old('description', $product->description) }}</textarea></div>
        <div class="col-md-4"><label class="form-label" for="color">Color</label><input id="color" name="color" value="{{ old('color', $product->color) }}" class="form-control"></div>
        @php
            $sizeRows = old('sizes');
            if (!is_array($sizeRows)) {
                $sizeRows = collect($product->sizeInventory())->map(fn ($quantity, $size) => ['size' => $size, 'quantity' => $quantity])->values()->all();
            }
            $sizeRows = $sizeRows ?: [['size' => '', 'quantity' => '']];
        @endphp
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <label class="form-label mb-0">Sizes and quantities</label>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="add-size"><span aria-hidden="true">+</span><span class="visually-hidden">Add size</span></button>
            </div>
            <div id="size-fields" class="d-grid gap-2 mt-2">
                @foreach($sizeRows as $index => $sizeRow)
                    <div class="row g-2 size-row">
                        <div class="col"><input name="sizes[{{ $index }}][size]" class="form-control" placeholder="Size {{ $index + 1 }}" value="{{ $sizeRow['size'] ?? '' }}"></div>
                        <div class="col"><input name="sizes[{{ $index }}][quantity]" type="number" min="0" class="form-control" placeholder="Quantity" value="{{ $sizeRow['quantity'] ?? '' }}"></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12"><label class="form-label" for="images">Add product photos</label><input id="images" type="file" name="images[]" accept="image/jpeg,image/png,image/webp" multiple class="form-control"><div id="image-preview" class="row g-2 mt-2"></div><div class="form-text">New photos will be added to the existing gallery.</div></div>
        <div class="col-12"><label id="current-photos-label" class="form-label">Current photos ({{ count($product->imagePaths()) }})</label><div class="row g-3">
            @forelse($product->imagePaths() as $image)
                <div class="col-6 col-md-3 product-photo-card"><div class="border rounded p-2"><img src="{{ asset('storage/' . $image) }}" class="img-fluid rounded" style="aspect-ratio:1;object-fit:cover" alt="{{ $product->name }} photo"><button type="button" class="btn btn-outline-danger btn-sm d-flex align-items-center gap-2 mt-2 photo-delete-button" data-image="{{ $image }}" data-bs-toggle="tooltip" title="Delete photo" aria-label="Delete photo"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg><span class="visually-hidden">Delete photo</span></button></div></div>
            @empty
                <div class="col-12"><p class="admin-muted mb-0">No photos uploaded yet.</p></div>
            @endforelse
        </div></div>
    </div>
    <button class="admin-button mt-4" type="submit">Save changes</button>
</form>

<div class="modal fade" id="deletePhotoModal" tabindex="-1" aria-labelledby="deletePhotoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header"><h2 class="modal-title fs-5" id="deletePhotoModalLabel">Delete this photo?</h2><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <div class="modal-body">This photo will be removed from the product gallery immediately.</div>
            <div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button><button type="button" class="btn btn-danger" id="confirmPhotoDelete">Delete photo</button></div>
        </div>
    </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1080">
    <div id="photoDeletedToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">Photo deleted successfully.</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script>
    const sizeFields = document.getElementById('size-fields');
    document.getElementById('add-size').addEventListener('click', () => {
        const index = sizeFields.querySelectorAll('.size-row').length;
        sizeFields.insertAdjacentHTML('beforeend', `<div class="row g-2 size-row"><div class="col"><input name="sizes[${index}][size]" class="form-control" placeholder="Size ${index + 1}"></div><div class="col"><input name="sizes[${index}][quantity]" type="number" min="0" class="form-control" placeholder="Quantity"></div></div>`);
    });

    const deletePhotoModal = new bootstrap.Modal(document.getElementById('deletePhotoModal'));
    const photoDeletedToastElement = document.getElementById('photoDeletedToast');
    const photoDeletedToast = bootstrap.Toast.getOrCreateInstance(photoDeletedToastElement, { delay: 3500 });
    const deletePhotoButton = document.getElementById('confirmPhotoDelete');
    const currentPhotosLabel = document.getElementById('current-photos-label');
    let photoPendingDeletion = null;

    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((element) => new bootstrap.Tooltip(element));
    document.querySelectorAll('.photo-delete-button').forEach((button) => {
        button.addEventListener('click', () => {
            photoPendingDeletion = button;
            deletePhotoModal.show();
        });
    });

    deletePhotoButton.addEventListener('click', async () => {
        if (!photoPendingDeletion) return;

        const selectedButton = photoPendingDeletion;
        const imagePath = selectedButton.dataset.image;
        deletePhotoButton.disabled = true;
        deletePhotoButton.textContent = 'Deleting...';

        try {
            const response = await fetch('{{ route('admin.products.images.destroy', $product) }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ image: imagePath }),
            });

            if (!response.ok) throw new Error('Photo could not be deleted.');

            selectedButton.closest('.product-photo-card').remove();
            currentPhotosLabel.textContent = `Current photos (${document.querySelectorAll('.product-photo-card').length})`;
            deletePhotoModal.hide();
            photoPendingDeletion = null;
            photoDeletedToastElement.classList.remove('text-bg-danger');
            photoDeletedToastElement.classList.add('text-bg-success');
            photoDeletedToastElement.querySelector('.toast-body').textContent = 'Photo deleted successfully.';
            photoDeletedToast.show();
        } catch (error) {
            photoDeletedToastElement.querySelector('.toast-body').textContent = error.message;
            photoDeletedToastElement.classList.remove('text-bg-success');
            photoDeletedToastElement.classList.add('text-bg-danger');
            photoDeletedToast.show();
        } finally {
            deletePhotoButton.disabled = false;
            deletePhotoButton.textContent = 'Delete photo';
        }
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