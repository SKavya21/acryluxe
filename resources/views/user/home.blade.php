@extends('layouts.app')

@section('content')

<!-- Carousel -->
<div id="carouselExample" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-inner">

        <div class="carousel-item active">
            <img src="/images/banner1.jpg" class="d-block w-100" height="400">
        </div>

        <div class="carousel-item">
            <img src="/images/banner2.jpg" class="d-block w-100" height="400">
        </div>

    </div>

    <button class="carousel-control-prev" data-bs-target="#carouselExample" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" data-bs-target="#carouselExample" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<!-- Products -->
<h2 class="mb-4">Latest Acrylic Bangles</h2>

<div class="row">

    @forelse($products as $product)
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
            <div class="card h-100 shadow-sm">

                <img src="{{ $product->image ?? '/images/default.png' }}" 
                     class="card-img-top" 
                     style="height:200px; object-fit:cover;">

                <div class="card-body">
                    <h5>{{ $product->name }}</h5>
                    <p class="text-muted">₹{{ $product->price }}</p>

                    <button class="btn btn-primary w-100">
                        Add to Cart
                    </button>
                </div>

            </div>
        </div>
    @empty
        <p>No products available</p>
    @endforelse

</div>

@endsection