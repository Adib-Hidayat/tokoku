@extends('layouts.app')

@section('title', 'Produk')
@section('page-title', 'Manajemen Produk')

@section('content')
<!-- Header & Filter Bar -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('products.index') }}" class="row g-2 align-items-center">
            <div class="col-12 col-sm-5 col-lg-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama / kode produk..."
                        value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-6 col-sm-3 col-lg-2">
                <select name="category" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-sm-3 col-lg-2">
                <select name="stock_filter" class="form-select">
                    <option value="">Semua Stok</option>
                    <option value="low" {{ request('stock_filter') == 'low' ? 'selected' : '' }}>Stok Menipis</option>
                    <option value="out" {{ request('stock_filter') == 'out' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
            <div class="col-12 col-sm-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel me-1"></i>Filter
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-lg"></i>
                </a>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-1"></i>Tambah Produk
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Results Summary -->
<div class="d-flex align-items-center justify-content-between mb-3">
    <span class="text-muted" style="font-size:0.85rem">
        Menampilkan <strong>{{ $products->firstItem() ?? 0 }}</strong>–<strong>{{ $products->lastItem() ?? 0 }}</strong> dari <strong>{{ $products->total() }}</strong> produk
    </span>
</div>

<!-- Product Grid -->
<div class="row g-4">
    @forelse($products as $product)
        <div class="col-6 col-lg-4 col-xl-3">
            <div class="card product-card h-100 position-relative">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="product-img" alt="{{ $product->name }}">
                @else
                    <div class="product-img-placeholder"><i class="bi bi-image"></i></div>
                @endif
                <span class="badge stock-badge {{ $product->stock == 0 ? 'bg-danger' : ($product->stock <= 5 ? 'bg-warning text-dark' : 'bg-success') }}">
                    {{ $product->stock == 0 ? 'Habis' : 'Stok: ' . $product->stock }}
                </span>
                <div class="card-body d-flex flex-column">
                    <div class="product-category d-flex justify-content-between align-items-center">
                        <span>{{ $product->category->name ?? '-' }}</span>
                        <span class="text-muted" style="font-size:0.65rem;font-weight:600">{{ $product->code }}</span>
                    </div>
                    <div class="product-name">{{ $product->name }}</div>
                    <p class="text-muted mt-1 mb-2" style="font-size:0.78rem;line-height:1.5;flex-grow:1">
                        {{ Str::limit($product->description, 60) }}
                    </p>
                    <div class="product-price mb-3">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                    <div class="d-flex gap-2 mt-auto">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary flex-fill">
                            <i class="bi bi-eye me-1"></i>Detail
                        </a>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST"
                            onsubmit="return confirm('Hapus produk {{ addslashes($product->name) }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="bi bi-search" style="font-size:3rem;color:#cbd5e1"></i>
                    <h6 class="mt-3 text-muted">Produk tidak ditemukan</h6>
                    <p class="text-muted mb-3" style="font-size:0.85rem">Coba ubah filter atau tambah produk baru</p>
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Produk
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

@if($products->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
</div>
@endif
@endsection
