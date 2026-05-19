@extends('layouts.app')

@section('title', 'Transaksi')
@section('page-title', 'Manajemen Transaksi')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="mb-1 fw-700" style="color:#1e293b">Daftar Transaksi</h5>
        <p class="text-muted mb-0" style="font-size:0.85rem">Riwayat semua penjualan</p>
    </div>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Transaksi Baru
    </a>
</div>

<!-- Filter -->
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('transactions.index') }}" class="row g-2 align-items-center">
            <div class="col-12 col-sm-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari invoice / nama pembeli..."
                        value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-6 col-sm-3">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <div class="col-auto d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-funnel me-1"></i>Filter</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Pembeli</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                    <tr>
                        <td>
                            <a href="{{ route('transactions.show', $t) }}" class="text-decoration-none"
                                style="font-weight:600;color:#6366f1">{{ $t->invoice_number }}</a>
                        </td>
                        <td style="font-size:0.875rem">{{ $t->pembeli ?? '<span class="text-muted">-</span>' }}</td>
                        <td style="font-size:0.82rem;color:#64748b;white-space:nowrap">
                            {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}
                        </td>
                        <td style="font-weight:700;color:#1e293b">
                            Rp {{ number_format($t->total, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($t->status == 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('transactions.show', $t) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($t->status == 'selesai')
                                    <form action="{{ route('transactions.destroy', $t) }}" method="POST"
                                        onsubmit="return confirm('Batalkan transaksi ini? Stok akan dikembalikan.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Batalkan Transaksi">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('transactions.forceDelete', $t) }}" method="POST"
                                    onsubmit="return confirm('Hapus permanen transaksi ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Permanen">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-receipt" style="font-size:2.5rem;display:block;margin-bottom:8px"></i>
                            Belum ada transaksi. <a href="{{ route('transactions.create') }}">Buat transaksi pertama</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transactions->hasPages())
        <div class="card-body">{{ $transactions->links() }}</div>
    @endif
</div>
@endsection
