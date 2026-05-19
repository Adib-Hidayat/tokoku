@extends('layouts.app')

@section('title', 'Barang Keluar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Riwayat Barang Keluar</h2>
    <a href="{{ route('outgoing-goods.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Barang Keluar</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($outgoingGoods as $outgoing)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($outgoing->date)->format('d-m-Y') }}</td>
                        <td>
                            @if($outgoing->product)
                                <strong>{{ $outgoing->product->name }}</strong><br>
                                <small class="text-muted">{{ $outgoing->product->code }}</small>
                            @else
                                <span class="text-danger">Produk Dihapus</span>
                            @endif
                        </td>
                        <td><span class="badge bg-danger">-{{ $outgoing->quantity }}</span></td>
                        <td class="text-center">
                            <form action="{{ route('outgoing-goods.destroy', $outgoing) }}" method="POST" onsubmit="return confirm('Menghapus transaksi ini akan MENGEMBALIKAN stok produk. Lanjutkan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">Belum ada riwayat barang keluar</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            {{ $outgoingGoods->links() }}
        </div>
    </div>
</div>
@endsection
