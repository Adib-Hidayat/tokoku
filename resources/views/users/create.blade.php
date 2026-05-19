@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-person-plus me-2 text-primary"></i>Tambah User Baru
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Budi Santoso">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="Contoh: budi@toko.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Role / Hak Akses <span class="text-danger">*</span></label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir (Transaksi & Stok)</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Semua Modul)</option>
                            <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Owner (Laporan Keuangan & Semua Modul)</option>
                        </select>
                        <div class="form-text">Owner dan Admin dapat mengakses laporan keuangan.</div>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimal 6 karakter">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password">
                    </div>

                    <!-- Preview Card -->
                    <div class="p-3 mb-4 rounded-3" style="background:#f8fafc;border:1px dashed #e2e8f0">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);
                                display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <div style="font-size:0.82rem;color:#64748b">User baru akan bisa login dengan:</div>
                                <div style="font-size:0.875rem;font-weight:600;color:#1e293b">Email + Password yang ditentukan</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-person-check me-2"></i>Buat Akun
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
