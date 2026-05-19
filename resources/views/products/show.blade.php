@extends('layouts.app')

@section('title', $product->name)
@section('page-title', 'Detail Produk')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center p-4">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                        style="max-width:100%;max-height:260px;object-fit:cover;border-radius:16px;margin-bottom:20px">
                @else
                    <div style="height:200px;background:linear-gradient(135deg,#f1f5f9,#e2e8f0);border-radius:16px;display:flex;align-items:center;justify-content:center;margin-bottom:20px">
                        <i class="bi bi-image" style="font-size:3rem;color:#94a3b8"></i>
                    </div>
                @endif
                <span class="badge mb-2" style="background:#ede9fe;color:#6d28d9">{{ $product->category->name ?? '-' }}</span>
                <h5 class="fw-700 mb-1" style="color:#1e293b">{{ $product->name }}</h5>
                <p class="text-muted mb-3" style="font-size:0.85rem">SKU: {{ $product->code }}</p>
                <div style="font-size:1.5rem;font-weight:700;color:#6366f1;margin-bottom:16px">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
                <div class="d-flex justify-content-center gap-2 mb-4">
                    <span class="badge py-2 px-3 {{ $product->stock == 0 ? 'bg-danger' : ($product->stock <= 5 ? 'bg-warning text-dark' : 'bg-success') }}" style="font-size:0.9rem">
                        <i class="bi bi-archive me-1"></i>Stok: {{ $product->stock }} unit
                    </span>
                </div>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-info-circle me-2 text-primary"></i>Informasi Produk</div>
            <div class="card-body">
                @if($product->description)
                    <p style="font-size:0.9rem;color:#334155;line-height:1.7">{{ $product->description }}</p>
                @else
                    <p class="text-muted" style="font-size:0.85rem">Tidak ada deskripsi</p>
                @endif
                <hr>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;color:#64748b;text-transform:uppercase;letter-spacing:0.5px">Tanggal Ditambahkan</div>
                        <div style="font-size:0.9rem;font-weight:500;color:#1e293b">{{ $product->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div style="font-size:0.75rem;color:#64748b;text-transform:uppercase;letter-spacing:0.5px">Terakhir Diupdate</div>
                        <div style="font-size:0.9rem;font-weight:500;color:#1e293b">{{ $product->updated_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Stok Terbaru</span>
                <a href="{{ route('stock.index', ['product_id' => $product->id]) }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($stockLogs as $log)
                    <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom">
                        <div style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;
                            background:{{ $log->tipe == 'masuk' ? '#d1fae5' : '#fee2e2' }};
                            color:{{ $log->tipe == 'masuk' ? '#059669' : '#dc2626' }}">
                            <i class="bi bi-arrow-{{ $log->tipe == 'masuk' ? 'down' : 'up' }}-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div style="font-size:0.85rem;font-weight:600;color:#1e293b">
                                {{ $log->tipe == 'masuk' ? 'Stok Masuk' : 'Stok Keluar' }}
                            </div>
                            <div style="font-size:0.75rem;color:#64748b">{{ $log->keterangan }}</div>
                        </div>
                        <div class="text-end">
                            <div style="font-size:0.95rem;font-weight:700;color:{{ $log->tipe == 'masuk' ? '#059669' : '#dc2626' }}">
                                {{ $log->tipe == 'masuk' ? '+' : '-' }}{{ $log->jumlah }}
                            </div>
                            <div style="font-size:0.72rem;color:#94a3b8">{{ $log->tanggal->format('d M Y') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted" style="font-size:0.85rem">Belum ada riwayat stok</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Produk
    </a>
</div>
@endsection
