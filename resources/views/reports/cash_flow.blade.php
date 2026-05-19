@extends('layouts.app')

@section('title', 'Laporan Arus Kas')
@section('page-title', 'Laporan Arus Kas (Cash Flow)')

@section('content')
<div class="card shadow-sm border-0 mb-4 no-print">
    <div class="card-body">
        <form action="{{ route('reports.cash_flow') }}" method="GET" class="row g-3 align-items-end">
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
                    <i class="bi bi-filter me-2"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 text-center">
        <h5 class="fw-bold mb-1">Laporan Arus Kas</h5>
        <p class="text-muted mb-0 small">Periode: {{ date('d/m/Y', strtotime($startDate)) }} - {{ date('d/m/Y', strtotime($endDate)) }}</p>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Tanggal</th>
                    <th>Kategori / Sumber</th>
                    <th>Pemasukan (Debit)</th>
                    <th>Pengeluaran (Kredit)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php $totalDebit = 0; $totalKredit = 0; @endphp
                @foreach($logs as $log)
                    <tr>
                        <td class="text-center">{{ $log->date->format('d/m/Y') }}</td>
                        <td>{{ $log->category }}</td>
                        <td class="text-end text-success">
                            @if($log->type == 'pemasukan')
                                Rp {{ number_format($log->amount, 0, ',', '.') }}
                                @php $totalDebit += $log->amount; @endphp
                            @else - @endif
                        </td>
                        <td class="text-end text-danger">
                            @if($log->type == 'pengeluaran')
                                Rp {{ number_format($log->amount, 0, ',', '.') }}
                                @php $totalKredit += $log->amount; @endphp
                            @else - @endif
                        </td>
                        <td class="small">{{ $log->description }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="table-light fw-bold">
                <tr>
                    <td colspan="2" class="text-center">TOTAL</td>
                    <td class="text-end text-success">Rp {{ number_format($totalDebit, 0, ',', '.') }}</td>
                    <td class="text-end text-danger">Rp {{ number_format($totalKredit, 0, ',', '.') }}</td>
                    <td class="text-center text-primary">SALDO: Rp {{ number_format($totalDebit - $totalKredit, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="card-footer bg-white border-top-0 pb-4 px-4 text-end no-print">
        <button onclick="window.print()" class="btn btn-outline-secondary">
            <i class="bi bi-printer me-2"></i>Cetak Laporan
        </button>
    </div>
</div>

<style>
@media print {
    .no-print { display: none !important; }
    body { background-color: white !important; }
    .card { border: none !important; }
}
</style>
@endsection
