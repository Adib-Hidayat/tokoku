@extends('layouts.app')

@section('title', 'Barang Masuk')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Riwayat Barang Masuk</h2>
    <a href="{{ route('incoming-goods.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Barang Masuk</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Supplier</th>
                        <th>Jumlah</th>
                        <th class="text-center" style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($incomingGoods as $incoming)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($incoming->date)->format('d-m-Y') }}</td>
                        <td>
                            @if($incoming->product)
                                <strong>{{ $incoming->product->name }}</strong><br>
                                <small class="text-muted">{{ $incoming->product->code }}</small>
                            @else
                                <span class="text-danger">Produk Dihapus</span>
                            @endif
                        </td>
                        <td>{{ $incoming->supplier->name ?? '-' }}</td>
                        <td><span class="badge bg-success">+{{ $incoming->quantity }}</span></td>
                        <td class="text-center">
                            <form action="{{ route('incoming-goods.destroy', $incoming) }}" method="POST" onsubmit="return confirm('Menghapus transaksi ini akan MENGURANGI stok produk. Lanjutkan?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada riwayat barang masuk</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            {{ $incomingGoods->links() }}
        </div>
    </div>
</div>
@endsection
