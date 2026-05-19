@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
.stat-card-1 { background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.stat-card-2 { background: linear-gradient(135deg, #06b6d4, #0891b2); }
.stat-card-3 { background: linear-gradient(135deg, #10b981, #059669); }
.stat-card-4 { background: linear-gradient(135deg, #f59e0b, #d97706); }
.stat-card-5 { background: linear-gradient(135deg, #ef4444, #dc2626); }
.chart-container { position: relative; height: 240px; }
</style>
@endpush

@section('content')
<!-- Stat Cards -->
<div class="row g-4 mb-4">
    <div class="col-6 col-xl-3">
        <div class="card stat-card stat-card-1 text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(255,255,255,0.2)"><i class="bi bi-box-seam"></i></div>
                <div>
                    <div style="font-size:1.8rem;font-weight:700;line-height:1">{{ $totalProducts }}</div>
                    <div style="font-size:0.8rem;opacity:0.85">Total Produk</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card stat-card-2 text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(255,255,255,0.2)"><i class="bi bi-tags"></i></div>
                <div>
                    <div style="font-size:1.8rem;font-weight:700;line-height:1">{{ $totalCategories }}</div>
                    <div style="font-size:0.8rem;opacity:0.85">Total Kategori</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card stat-card-3 text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(255,255,255,0.2)"><i class="bi bi-receipt"></i></div>
                <div>
                    <div style="font-size:1.8rem;font-weight:700;line-height:1">{{ $totalTransaksi }}</div>
                    <div style="font-size:0.8rem;opacity:0.85">Total Transaksi</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="card stat-card stat-card-4 text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon" style="background:rgba(255,255,255,0.2)"><i class="bi bi-currency-dollar"></i></div>
                <div>
                    <div style="font-size:1.2rem;font-weight:700;line-height:1.2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    <div style="font-size:0.8rem;opacity:0.85">Total Pendapatan</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Chart -->
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-bar-chart me-2 text-primary"></i>Pendapatan 7 Hari Terakhir</span>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alert -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-exclamation-triangle me-2 text-warning"></i>Stok Menipis</span>
                <a href="{{ route('stock.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($lowStockProducts as $p)
                    <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom">
                        <div style="width:38px;height:38px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;color:#d97706;font-size:1rem;flex-shrink:0">
                            <i class="bi bi-box"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div style="font-size:0.85rem;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $p->name }}</div>
                            <div style="font-size:0.75rem;color:#64748b">{{ $p->category->name ?? '-' }}</div>
                        </div>
                        <span class="badge {{ $p->stock == 0 ? 'bg-danger' : 'bg-warning text-dark' }}">
                            {{ $p->stock }} unit
                        </span>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-check-circle" style="font-size:2rem;color:#10b981"></i>
                        <div class="mt-2" style="font-size:0.85rem">Semua stok aman</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Transactions -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-clock-history me-2 text-primary"></i>Transaksi Terbaru</span>
                <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Pembeli</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTransactions as $t)
                                <tr>
                                    <td><a href="{{ route('transactions.show', $t) }}" class="text-primary fw-500 text-decoration-none">{{ $t->invoice_number }}</a></td>
                                    <td>{{ $t->pembeli ?? '-' }}</td>
                                    <td class="fw-600">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                                    <td>
                                        @if($t->status == 'selesai')
                                            <span class="badge bg-success">Selesai</span>
                                        @else
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada transaksi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Stock Logs -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-arrow-left-right me-2 text-primary"></i>Log Stok Terbaru</span>
                <a href="{{ route('stock.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentStockLogs as $log)
                    <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom">
                        <div style="width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:0.9rem;flex-shrink:0;
                            background:{{ $log->tipe == 'masuk' ? '#d1fae5' : '#fee2e2' }};
                            color:{{ $log->tipe == 'masuk' ? '#059669' : '#dc2626' }}">
                            <i class="bi bi-arrow-{{ $log->tipe == 'masuk' ? 'down' : 'up' }}-circle"></i>
                        </div>
                        <div class="flex-grow-1 overflow-hidden">
                            <div style="font-size:0.82rem;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $log->product->name ?? '-' }}</div>
                            <div style="font-size:0.72rem;color:#64748b">{{ $log->keterangan }}</div>
                        </div>
                        <div class="text-end" style="flex-shrink:0">
                            <div style="font-size:0.85rem;font-weight:700;color:{{ $log->tipe == 'masuk' ? '#059669' : '#dc2626' }}">
                                {{ $log->tipe == 'masuk' ? '+' : '-' }}{{ $log->jumlah }}
                            </div>
                            <div style="font-size:0.7rem;color:#94a3b8">{{ $log->tanggal->format('d M') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted" style="font-size:0.85rem">Belum ada log stok</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Pendapatan',
            data: {!! json_encode($chartData) !!},
            backgroundColor: 'rgba(99,102,241,0.2)',
            borderColor: '#6366f1',
            borderWidth: 2,
            borderRadius: 8,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f1f5f9' },
                ticks: {
                    callback: v => 'Rp ' + new Intl.NumberFormat('id').format(v),
                    font: { size: 11 }
                }
            },
            x: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});
</script>
@endpush
