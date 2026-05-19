@extends('layouts.app')

@section('title', $category->name)
@section('page-title', 'Produk dalam Kategori: ' . $category->name)

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="mb-1 fw-700" style="color:#1e293b">{{ $category->name }}</h5>
        <p class="text-muted mb-0" style="font-size:0.85rem">{{ $category->description ?? 'Tidak ada deskripsi' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('products.create', ['category_id' => $category->id]) }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Produk
        </a>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    @forelse($products as $product)
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="card product-card h-100 position-relative">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="product-img" alt="{{ $product->name }}">
                @else
                    <div class="product-img-placeholder"><i class="bi bi-image"></i></div>
                @endif
                <span class="badge stock-badge {{ $product->stock == 0 ? 'bg-danger' : ($product->stock <= 5 ? 'bg-warning text-dark' : 'bg-success') }}">
                    Stok: {{ $product->stock }}
                </span>
                <div class="card-body">
                    <div class="product-name">{{ $product->name }}</div>
                    <div class="product-category mb-2"><i class="bi bi-upc me-1"></i>{{ $product->code }}</div>
                    <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary flex-fill">Detail</a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="bi bi-box-seam" style="font-size:3rem;color:#cbd5e1"></i>
                    <h6 class="mt-3 text-muted">Belum ada produk di kategori ini</h6>
                    <a href="{{ route('products.create', ['category_id' => $category->id]) }}" class="btn btn-primary mt-2">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Produk
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

@if($products->hasPages())
<div class="d-flex justify-content-center mt-4">{{ $products->links() }}</div>
@endif
@endsection
