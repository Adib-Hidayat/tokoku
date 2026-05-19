@extends('layouts.app')

@section('title', 'Hutang & Piutang')
@section('page-title', 'Manajemen Hutang & Piutang')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Tambah Catatan</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('debts.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Jenis</label>
                        <select name="type" class="form-select" required>
                            <option value="piutang">Piutang (Orang Berhutang ke Kita)</option>
                            <option value="hutang">Hutang (Kita Berhutang ke Orang)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Pihak / Pelanggan</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah (Rp)</label>
                        <input type="number" name="amount" class="form-control" placeholder="0" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Jatuh Tempo (Opsional)</label>
                        <input type="date" name="due_date" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-save me-2"></i>Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Total</th>
                            <th>Sisa</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($debts as $item)
                            <tr>
                                <td><div class="fw-bold">{{ $item->name }}</div></td>
                                <td>
                                    <span class="badge {{ $item->type == 'piutang' ? 'bg-info text-dark' : 'bg-warning text-dark' }}">
                                        {{ ucfirst($item->type) }}
                                    </span>
                                </td>
                                <td>Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
                                <td class="fw-bold {{ $item->status == 'lunas' ? 'text-success' : 'text-danger' }}">
                                    Rp {{ number_format($item->amount - $item->total_paid, 0, ',', '.') }}
                                </td>
                                <td>{{ $item->due_date ? $item->due_date->format('d/m/Y') : '-' }}</td>
                                <td>
                                    @if($item->status == 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-danger">Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item->status != 'lunas')
                                        <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#payModal{{ $item->id }}">
                                            Bayar
                                        </button>
                                    @endif

                                    <!-- Modal Bayar -->
                                    <div class="modal fade" id="payModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <form action="{{ route('debts.pay', $item) }}" method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Catat Pembayaran</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-start">
                                                        <p>Membayar {{ $item->type }} atas nama <strong>{{ $item->name }}</strong>.</p>
                                                        <p>Sisa Tagihan: <strong>Rp {{ number_format($item->amount - $item->total_paid, 0, ',', '.') }}</strong></p>
                                                        <div class="mb-3">
                                                            <label class="form-label">Jumlah Pembayaran</label>
                                                            <input type="number" name="amount" class="form-control" max="{{ $item->amount - $item->total_paid }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal Bayar</label>
                                                            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                                                        </div>
                                                        <div class="mb-0">
                                                            <label class="form-label">Catatan</label>
                                                            <input type="text" name="note" class="form-control" placeholder="Opsional...">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success">Simpan Pembayaran</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">Belum ada catatan hutang/piutang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
