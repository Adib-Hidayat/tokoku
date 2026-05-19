@extends('layouts.app')

@section('title', 'Riwayat Stok')
@section('page-title', 'Riwayat Stok')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <span><i class="bi bi-clock-history me-2 text-primary"></i>Log Pergerakan Stok</span>
                <!-- Filter -->
                <form method="GET" action="{{ route('stock.history') }}" class="d-flex gap-2 flex-wrap">
                    <select name="product_id" class="form-select form-select-sm" style="width:auto">
                        <option value="">Semua Produk</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                    <select name="tipe" class="form-select form-select-sm" style="width:auto">
                        <option value="">Semua Tipe</option>
                        <option value="masuk" {{ request('tipe') == 'masuk' ? 'selected' : '' }}>Masuk</option>
                        <option value="keluar" {{ request('tipe') == 'keluar' ? 'selected' : '' }}>Keluar</option>
                    </select>
                    <input type="date" name="tanggal" class="form-control form-control-sm" style="width:auto"
                        value="{{ request('tanggal') }}">
                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    <a href="{{ route('stock.history') }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Produk</th>
                            <th>Tipe</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td style="white-space:nowrap;font-size:0.82rem;color:#64748b">
                                    {{ $log->tanggal->format('d M Y') }}
                                </td>
                                <td>
                                    <div style="font-weight:600;font-size:0.85rem;color:#1e293b">{{ $log->product->name ?? '-' }}</div>
                                    <div style="font-size:0.75rem;color:#94a3b8">{{ $log->product->code ?? '' }}</div>
                                </td>
                                <td>
                                    @if($log->tipe == 'masuk')
                                        <span class="badge" style="background:#d1fae5;color:#065f46">
                                            <i class="bi bi-arrow-down-circle me-1"></i>Masuk
                                        </span>
                                    @else
                                        <span class="badge" style="background:#fee2e2;color:#991b1b">
                                            <i class="bi bi-arrow-up-circle me-1"></i>Keluar
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span style="font-weight:700;color:{{ $log->tipe == 'masuk' ? '#059669' : '#dc2626' }}">
                                        {{ $log->tipe == 'masuk' ? '+' : '-' }}{{ $log->jumlah }}
                                    </span>
                                </td>
                                <td style="font-size:0.82rem;color:#64748b">{{ $log->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox" style="font-size:2rem;display:block;margin-bottom:8px"></i>
                                    Belum ada riwayat stok
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($logs->hasPages())
                <div class="card-footer bg-white">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
