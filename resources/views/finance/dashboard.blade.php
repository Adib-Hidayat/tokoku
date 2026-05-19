@extends('layouts.app')

@section('title', 'Dashboard Keuangan')
@section('page-title', 'Dashboard Keuangan')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card h-100 bg-primary text-white border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-title mb-0 opacity-75">Pemasukan Hari Ini</h6>
                    <i class="bi bi-arrow-up-right-circle fs-4"></i>
                </div>
                <h3 class="fw-bold mb-0">Rp {{ number_format($incomeToday, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 bg-danger text-white border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-title mb-0 opacity-75">Pengeluaran Hari Ini</h6>
                    <i class="bi bi-arrow-down-left-circle fs-4"></i>
                </div>
                <h3 class="fw-bold mb-0">Rp {{ number_format($expenseToday, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 bg-success text-white border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-title mb-0 opacity-75">Pemasukan Bulan Ini</h6>
                    <i class="bi bi-calendar-check fs-4"></i>
                </div>
                <h3 class="fw-bold mb-0">Rp {{ number_format($incomeMonth, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 bg-warning text-dark border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-title mb-0 opacity-75">Laba Bersih (Bulan Ini)</h6>
                    <i class="bi bi-cash-stack fs-4"></i>
                </div>
                <h3 class="fw-bold mb-0">Rp {{ number_format($incomeMonth - $expenseMonth, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Statistik Keuangan (7 Hari Terakhir)</h5>
            </div>
            <div class="card-body">
                <canvas id="financeChart" height="280"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Aktivitas Terakhir</h5>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentTransactions as $item)
                        <div class="list-group-item px-4 py-3 border-0 border-bottom">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <div class="fw-600 text-dark">{{ $item->category }}</div>
                                <div class="fw-bold {{ $item->type == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                    {{ $item->type == 'pemasukan' ? '+' : '-' }} Rp {{ number_format($item->amount, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $item->date->format('d M Y') }}</small>
                                <small class="text-muted">{{ Str::limit($item->description, 20) }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">Belum ada riwayat</div>
                    @endforelse
                </div>
            </div>
            <div class="card-footer bg-white text-center py-3">
                <a href="{{ route('finance.index') }}" class="btn btn-sm btn-link text-decoration-none">Lihat Semua</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('financeChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [
                {
                    label: 'Pemasukan',
                    data: {!! json_encode($chartData['income']) !!},
                    backgroundColor: 'rgba(99, 102, 241, 0.8)',
                    borderRadius: 5
                },
                {
                    label: 'Pengeluaran',
                    data: {!! json_encode($chartData['expense']) !!},
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
@endsection
