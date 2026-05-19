@extends('layouts.app')

@section('title', 'Laporan Laba Rugi')
@section('page-title', 'Laporan Laba Rugi')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form action="{{ route('reports.profit_loss') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">Dari Tanggal</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold">Sampai Tanggal</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-2"></i>Filter Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 text-center">
                <h5 class="fw-bold mb-1">Laporan Laba Rugi</h5>
                <p class="text-muted mb-0 small">Periode: {{ date('d/m/Y', strtotime($startDate)) }} - {{ date('d/m/Y', strtotime($endDate)) }}</p>
            </div>
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-md-4 text-center">
                        <div class="p-3 border rounded-3 bg-light mb-2">
                            <div class="text-muted small mb-1">Total Pemasukan</div>
                            <h4 class="fw-bold text-success mb-0">Rp {{ number_format($income, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="p-3 border rounded-3 bg-light mb-2">
                            <div class="text-muted small mb-1">Total Pengeluaran</div>
                            <h4 class="fw-bold text-danger mb-0">Rp {{ number_format($expense, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="p-3 border rounded-3 {{ $profit >= 0 ? 'bg-success text-white' : 'bg-danger text-white' }} mb-2">
                            <div class="small opacity-75 mb-1">Laba/Rugi Bersih</div>
                            <h4 class="fw-bold mb-0">Rp {{ number_format($profit, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-bold border-bottom pb-2 mb-3">Rincian Pemasukan</h6>
                        <table class="table table-sm">
                            @foreach($incomeDetails as $item)
                                <tr>
                                    <td>{{ $item->category }}</td>
                                    <td class="text-end">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-light fw-bold">
                                <td>TOTAL</td>
                                <td class="text-end">Rp {{ number_format($income, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-bold border-bottom pb-2 mb-3">Rincian Pengeluaran</h6>
                        <table class="table table-sm">
                            @foreach($expenseDetails as $item)
                                <tr>
                                    <td>{{ $item->category }}</td>
                                    <td class="text-end">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-light fw-bold">
                                <td>TOTAL</td>
                                <td class="text-end">Rp {{ number_format($expense, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-top-0 pb-4 px-4 text-end no-print">
                <button onclick="window.print()" class="btn btn-outline-secondary">
                    <i class="bi bi-printer me-2"></i>Cetak Laporan
                </button>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    .card { border: none !important; shadow: none !important; }
}
</style>
@endsection
