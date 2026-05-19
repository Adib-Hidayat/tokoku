@extends('layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="mb-1 fw-700" style="color:#1e293b">Daftar User</h5>
        <p class="text-muted mb-0" style="font-size:0.85rem">Kelola akun pengguna yang dapat login ke sistem</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Tambah User
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Dibuat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                    <tr>
                        <td style="color:#94a3b8;font-size:0.85rem">{{ $users->firstItem() + $i }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);
                                    display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.85rem;flex-shrink:0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:0.875rem;color:#1e293b">{{ $user->name }}</div>
                                    @if($user->id === auth()->id())
                                        <span class="badge" style="background:#ede9fe;color:#6d28d9;font-size:0.68rem">Akun Anda</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="font-size:0.875rem;color:#64748b">{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'owner')
                                <span class="badge bg-primary">Owner</span>
                            @elseif($user->role == 'admin')
                                <span class="badge bg-info">Admin</span>
                            @else
                                <span class="badge bg-secondary">Kasir</span>
                            @endif
                        </td>
                        <td style="font-size:0.82rem;color:#94a3b8;white-space:nowrap">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                        onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-people" style="font-size:2.5rem;display:block;margin-bottom:8px"></i>
                            Belum ada user
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
        <div class="card-body">{{ $users->links() }}</div>
    @endif
</div>

<div class="card mt-4" style="background:#f0fdf4;border:1px solid #bbf7d0">
    <div class="card-body d-flex align-items-start gap-3">
        <i class="bi bi-info-circle-fill text-success mt-1" style="font-size:1.1rem;flex-shrink:0"></i>
        <div>
            <div style="font-weight:600;color:#065f46;font-size:0.875rem">Cara Menambah User Baru</div>
            <div style="font-size:0.82rem;color:#047857;margin-top:4px;line-height:1.6">
                Klik tombol <strong>"Tambah User"</strong>, isi nama, email, dan password. User baru langsung bisa login ke sistem menggunakan email dan password yang ditentukan.
            </div>
        </div>
    </div>
</div>
@endsection
