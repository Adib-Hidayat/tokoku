@extends('layouts.app')

@section('title', 'Pencatatan Keuangan')
@section('page-title', 'Pencatatan Keuangan')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2 text-primary"></i>Input Transaksi Manual</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('finance.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Jenis Transaksi</label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="pemasukan">Pemasukan (+)</option>
                            <option value="pengeluaran">Pengeluaran (-)</option>
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" list="categoryOptions" class="form-control @error('category') is-invalid @enderror" placeholder="Contoh: Listrik, Gaji, Restock..." required>
                        <datalist id="categoryOptions">
                            <option value="Penjualan">
                            <option value="Operasional">
                            <option value="Listrik & Air">
                            <option value="Gaji Karyawan">
                            <option value="Restock Barang">
                            <option value="Lain-lain">
                        </datalist>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah (Rp)</label>
                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" placeholder="0" required>
                        @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ date('Y-m-d') }}" required>
                        @error('date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Catatan opsional..."></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Bukti Transaksi (Gambar)</label>
                        <input type="file" name="proof_image" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <i class="bi bi-save me-2"></i>Simpan Catatan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-list-ul me-2 text-primary"></i>Riwayat Arus Kas</h6>
                <form action="{{ route('finance.index') }}" method="GET" class="d-flex gap-2">
                    <select name="type" class="form-select form-select-sm" style="width: auto;">
                        <option value="">Semua</option>
                        <option value="pemasukan" {{ request('type') == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="pengeluaran" {{ request('type') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-outline-secondary"><i class="bi bi-filter"></i></button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th class="text-end">Jumlah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($finances as $item)
                            <tr>
                                <td style="font-size: 0.85rem;">{{ $item->date->format('d/m/Y') }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $item->category }}</span></td>
                                <td style="font-size: 0.85rem;">
                                    {{ $item->description }}
                                    @if($item->reference_id)
                                        <br><small class="text-primary fw-bold">REF: {{ $item->reference_id }}</small>
                                    @endif
                                </td>
                                <td class="text-end fw-bold {{ $item->type == 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                    {{ $item->type == 'pemasukan' ? '+' : '-' }} {{ number_format($item->amount, 0, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-link py-0" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                            @if($item->proof_image)
                                                <li><a class="dropdown-item" href="{{ asset('storage/' . $item->proof_image) }}" target="_blank"><i class="bi bi-image me-2"></i>Lihat Bukti</a></li>
                                            @endif
                                            <li>
                                                <form action="{{ route('finance.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash me-2"></i>Hapus</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada riwayat transaksi keuangan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($finances->hasPages())
                <div class="card-footer bg-white">
                    {{ $finances->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
