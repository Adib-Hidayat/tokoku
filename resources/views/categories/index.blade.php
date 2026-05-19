@extends('layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="mb-1 fw-700" style="color:#1e293b">Daftar Kategori</h5>
        <p class="text-muted mb-0" style="font-size:0.85rem">Kelola kategori produk Anda</p>
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
    </a>
</div>

<!-- Category Grid -->
<div class="row g-4">
    @forelse($categories as $category)
        <div class="col-sm-6 col-lg-4 col-xl-3">
            <div class="card category-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="category-icon" style="background:{{ ['#ede9fe','#dbeafe','#d1fae5','#fef3c7','#fce7f3','#e0f2fe'][($category->id - 1) % 6] }};color:{{ ['#7c3aed','#1d4ed8','#065f46','#92400e','#9d174d','#0369a1'][($category->id - 1) % 6] }}">
                            <i class="bi bi-tag"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-sm" style="border:1px solid #e2e8f0;border-radius:8px;padding:4px 8px" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:12px;font-size:0.85rem">
                                <li><a class="dropdown-item" href="{{ route('categories.show', $category) }}"><i class="bi bi-eye me-2 text-primary"></i>Lihat Produk</a></li>
                                <li><a class="dropdown-item" href="{{ route('categories.edit', $category) }}"><i class="bi bi-pencil me-2 text-warning"></i>Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori {{ $category->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Hapus</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h6 class="fw-700 mb-1" style="color:#1e293b">{{ $category->name }}</h6>
                    <p class="text-muted mb-3" style="font-size:0.8rem;line-height:1.5;min-height:36px">
                        {{ $category->description ?? 'Tidak ada deskripsi' }}
                    </p>
                    <div class="d-flex align-items-center justify-content-between">
                        <span style="font-size:0.8rem;color:#64748b">
                            <i class="bi bi-box-seam me-1"></i>{{ $category->products_count }} produk
                        </span>
                        <a href="{{ route('categories.show', $category) }}" class="btn btn-sm" style="background:#f1f5f9;color:#6366f1;border:none">
                            Lihat <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card text-center py-5">
                <div class="card-body">
                    <i class="bi bi-tags" style="font-size:3rem;color:#cbd5e1"></i>
                    <h6 class="mt-3 text-muted">Belum ada kategori</h6>
                    <p class="text-muted mb-3" style="font-size:0.85rem">Mulai dengan menambahkan kategori pertama Anda</p>
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg me-2"></i>Tambah Kategori
                    </a>
                </div>
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($categories->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $categories->links() }}
</div>
@endif
@endsection
