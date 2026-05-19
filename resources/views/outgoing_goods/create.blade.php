@extends('layouts.app')

@section('title', 'Tambah Barang Keluar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Tambah Barang Keluar (Penjualan)</h2>
    <a href="{{ route('outgoing-goods.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> Menyimpan transaksi ini akan otomatis <strong>mengurangi</strong> stok produk. Pastikan stok mencukupi.
        </div>
        
        <form action="{{ route('outgoing-goods.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal Keluar <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="product_id" class="form-label">Produk <span class="text-danger">*</span></label>
                <select class="form-select @error('product_id') is-invalid @enderror" id="product_id" name="product_id" required>
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                            {{ $product->code }} - {{ $product->name }} (Stok saat ini: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="quantity" class="form-label">Jumlah Barang <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" required min="1">
                @error('quantity')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Transaksi</button>
        </form>
    </div>
</div>
@endsection
