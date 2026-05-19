@extends('layouts.app')

@section('title', 'Supplier')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Supplier</h2>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Tambah Supplier</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                    <tr>
                        <td>{{ $suppliers->firstItem() + $loop->index }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->address ?? '-' }}</td>
                        <td>{{ $supplier->contact ?? '-' }}</td>
                        <td class="text-center">
                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus supplier ini?')">
                                @csrf
                                @method('DELETE')
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data supplier</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-end mt-3">
            {{ $suppliers->links() }}
        </div>
    </div>
</div>
@endsection
