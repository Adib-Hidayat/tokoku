@extends('layouts.app')

@section('title', 'Stok Saat Ini')
@section('page-title', 'Stok Saat Ini')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <i class="bi bi-archive me-2 text-primary"></i>Daftar Stok Produk
                </div>
                <form method="GET" action="{{ route('stock.index') }}" class="d-flex gap-2 flex-wrap">
                    <div class="input-group input-group-sm" style="width: 200px;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                    </div>
                    <select name="category_id" class="form-select form-select-sm" style="width:auto">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    <a href="{{ route('stock.index') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $p)
                            <tr>
                                <td>
                                    <div style="font-weight:600;font-size:0.875rem">{{ $p->name }}</div>
                                    <div style="font-size:0.75rem;color:#94a3b8">{{ $p->code }}</div>
                                </td>
                                <td style="font-size:0.85rem;color:#64748b">{{ $p->category->name ?? '-' }}</td>
                                <td style="font-size:0.85rem;">Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                                <td>
                                    <span style="font-weight:700;color:{{ $p->stock <= 5 ? ($p->stock == 0 ? '#dc2626' : '#d97706') : '#10b981' }}">
                                        {{ $p->stock }} unit
                                    </span>
                                </td>
                                <td>
                                    @if($p->stock == 0)
                                        <span class="badge bg-danger">Habis</span>
                                    @elseif($p->stock <= 5)
                                        <span class="badge bg-warning text-dark">Menipis</span>
                                    @else
                                        <span class="badge bg-success">Tersedia</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#restockModal{{ $p->id }}">
                                        <i class="bi bi-plus-lg me-1"></i>Restock
                                    </button>

                                    <!-- Modal Restock -->
                                    <div class="modal fade" id="restockModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('stock.restock') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $p->id }}">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Restock Produk</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p class="mb-3">Produk: <strong>{{ $p->name }}</strong><br>Stok Saat Ini: <strong>{{ $p->stock }}</strong></p>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jumlah Tambah <span class="text-danger">*</span></label>
                                                            <input type="number" name="jumlah" class="form-control" min="1" required placeholder="Jumlah unit...">
                                                        </div>
                                                        <div class="mb-0">
                                                            <label class="form-label">Keterangan</label>
                                                            <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Barang datang dari supplier">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Belum ada data produk</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
                <div class="card-footer bg-white">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
