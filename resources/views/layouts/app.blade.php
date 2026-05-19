<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'JMS STORE') - Integrated Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-accent: #6366f1;
            --sidebar-text: #94a3b8;
            --sidebar-hover: #1e293b;
            --topbar-height: 64px;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            z-index: 1040;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            padding: 20px 20px 16px;
            border-bottom: 1px solid #1e293b;
            flex-shrink: 0;
        }
        .sidebar-brand .brand-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.3px;
        }
        .sidebar-brand .brand-sub {
            font-size: 0.72rem;
            color: var(--sidebar-text);
            margin-top: 2px;
        }
        .sidebar-brand .brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; color: #fff;
            flex-shrink: 0;
        }
        .sidebar-section {
            padding: 16px 16px 6px;
            font-size: 0.68rem;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }
        .sidebar-nav {
            padding: 0 12px;
            flex: 1;
        }
        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 2px;
            transition: all 0.2s ease;
            position: relative;
        }
        .sidebar-nav a .nav-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.95rem;
            background: transparent;
            transition: all 0.2s;
            flex-shrink: 0;
        }
        .sidebar-nav a:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }
        .sidebar-nav a:hover .nav-icon { background: #1e293b; }
        .sidebar-nav a.active {
            background: rgba(99,102,241,0.15);
            color: #818cf8;
        }
        .sidebar-nav a.active .nav-icon {
            background: rgba(99,102,241,0.2);
            color: #818cf8;
        }
        .sidebar-nav a .badge-dot {
            margin-left: auto;
            width: 18px; height: 18px;
            border-radius: 50%;
            background: #ef4444;
            color: #fff;
            font-size: 0.65rem;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid #1e293b;
            flex-shrink: 0;
        }
        .sidebar-user {
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-user .avatar {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 0.85rem;
        }
        .sidebar-user .user-info .name {
            font-size: 0.82rem; font-weight: 600; color: #e2e8f0;
        }
        .sidebar-user .user-info .role {
            font-size: 0.7rem; color: #475569;
        }

        /* ===== TOPBAR ===== */
        .topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            z-index: 1030;
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .topbar .page-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
        }
        .topbar .breadcrumb {
            margin-bottom: 0;
            font-size: 0.78rem;
        }
        .topbar .ms-auto { margin-left: auto !important; }
        .topbar-actions { display: flex; align-items: center; gap: 8px; }
        .topbar-btn {
            width: 38px; height: 38px;
            border: 1px solid #e2e8f0;
            background: #fff;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            color: #64748b;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
        }
        .topbar-btn:hover { background: #f8fafc; color: #1e293b; }
        .topbar-btn .notify-badge {
            position: absolute; top: -4px; right: -4px;
            width: 16px; height: 16px;
            background: #ef4444;
            border-radius: 50%;
            color: #fff;
            font-size: 0.6rem;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            border: 2px solid #fff;
        }
        .logout-btn {
            display: flex; align-items: center; gap: 6px;
            padding: 7px 14px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            color: #64748b;
            font-size: 0.82rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }
        .logout-btn:hover { background: #fef2f2; border-color: #fca5a5; color: #ef4444; }

        /* ===== MAIN CONTENT ===== */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            padding-top: var(--topbar-height);
            min-height: 100vh;
        }
        .main-content {
            padding: 28px;
        }

        /* ===== CARDS ===== */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .card-header {
            background: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 16px 20px;
            font-weight: 600;
            color: #1e293b;
            border-radius: 16px 16px 0 0 !important;
        }
        .card-body { padding: 20px; }

        /* ===== STAT CARDS ===== */
        .stat-card {
            border-radius: 16px;
            border: none;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
        .stat-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
        }

        /* ===== BUTTONS ===== */
        .btn { border-radius: 10px; font-weight: 500; font-size: 0.875rem; }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
        }
        .btn-primary:hover { background: linear-gradient(135deg, #4f46e5, #7c3aed); }
        .btn-sm { padding: 5px 12px; font-size: 0.8rem; border-radius: 8px; }

        /* ===== TABLE ===== */
        .table { font-size: 0.875rem; }
        .table th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 600;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            padding: 12px 16px;
        }
        .table td { padding: 12px 16px; vertical-align: middle; border-color: #f1f5f9; }
        .table tbody tr { transition: background 0.15s; }
        .table tbody tr:hover { background: #f8fafc; }

        /* ===== BADGES ===== */
        .badge { border-radius: 6px; font-weight: 500; padding: 4px 8px; }

        /* ===== ALERTS ===== */
        .alert { border: none; border-radius: 12px; font-size: 0.875rem; }

        /* ===== FORMS ===== */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            font-size: 0.875rem;
            padding: 10px 14px;
            transition: all 0.2s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .form-label { font-weight: 500; font-size: 0.875rem; color: #374151; margin-bottom: 6px; }
        .input-group-text { border-radius: 10px; border: 1px solid #e2e8f0; background: #f8fafc; }

        /* ===== PRODUCT CARDS ===== */
        .product-card {
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }
        .product-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.12); }
        .product-card .product-img {
            height: 180px;
            object-fit: cover;
            width: 100%;
            background: #f1f5f9;
        }
        .product-card .product-img-placeholder {
            height: 180px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            display: flex; align-items: center; justify-content: center;
            color: #94a3b8; font-size: 2.5rem;
        }
        .product-card .stock-badge {
            position: absolute; top: 12px; right: 12px;
        }
        .product-card .card-body { padding: 16px; }
        .product-card .product-name { font-weight: 600; color: #1e293b; font-size: 0.9rem; margin-bottom: 4px; }
        .product-card .product-price { font-weight: 700; color: #6366f1; font-size: 1rem; }
        .product-card .product-category { font-size: 0.75rem; color: #64748b; }

        /* ===== CATEGORY CARDS ===== */
        .category-card {
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .category-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.12); }
        .category-icon {
            width: 56px; height: 56px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem;
        }

        /* ===== PAGINATION ===== */
        .pagination .page-link {
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            color: #6366f1;
            font-size: 0.85rem;
            padding: 6px 12px;
            margin: 0 2px;
        }
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-color: transparent;
        }

        /* ===== MOBILE ===== */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-wrapper { margin-left: 0; }
            .topbar { left: 0; }
            .sidebar-overlay {
                display: none;
                position: fixed; inset: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1039;
            }
            .sidebar-overlay.show { display: block; }
        }

        /* ===== SCROLLBAR ===== */
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-track { background: transparent; }
        .sidebar::-webkit-scrollbar-thumb { background: #334155; border-radius: 2px; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-brand d-flex align-items-center gap-3">
        <div class="brand-icon"><i class="bi bi-shop-window"></i></div>
        <div>
            <div class="brand-name">JMS STORE</div>
            <div class="brand-sub">Sistem Manajemen Terintegrasi</div>
        </div>
    </div>

    <div class="sidebar-nav mt-2">
        <div class="sidebar-section">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-grid-1x2"></i></div>
            Dashboard
        </a>

        <div class="sidebar-section">Katalog</div>
        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-tags"></i></div>
            Kategori
        </a>
        <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-box-seam"></i></div>
            Produk
        </a>

        <div class="sidebar-section">Operasional</div>
        <a href="{{ route('stock.index') }}" class="{{ request()->routeIs('stock.index') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-archive"></i></div>
            Stok Saat Ini
            @php $lowStockCount = \App\Models\Product::where('stock', '<=', 5)->count(); @endphp
            @if($lowStockCount > 0)
                <span class="badge-dot">{{ $lowStockCount }}</span>
            @endif
        </a>
        <a href="{{ route('stock.history') }}" class="{{ request()->routeIs('stock.history') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-clock-history"></i></div>
            Riwayat Stok
        </a>
        <a href="{{ route('transactions.index') }}" class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-receipt"></i></div>
            Transaksi
        </a>

        @if(in_array(auth()->user()->role, ['owner', 'admin']))
        <div class="sidebar-section">Keuangan</div>
        <a href="{{ route('finance.dashboard') }}" class="{{ request()->routeIs('finance.dashboard') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-speedometer2"></i></div>
            Dashboard Keuangan
        </a>
        <a href="{{ route('finance.index') }}" class="{{ request()->routeIs('finance.index') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-cash-coin"></i></div>
            Pemasukan & Pengeluaran
        </a>
        <a href="{{ route('debts.index') }}" class="{{ request()->routeIs('debts.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-credit-card-2-front"></i></div>
            Hutang & Piutang
        </a>

        <div class="sidebar-section">Laporan</div>
        <a href="{{ route('reports.profit_loss') }}" class="{{ request()->routeIs('reports.profit_loss') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-file-earmark-bar-graph"></i></div>
            Laba Rugi
        </a>
        <a href="{{ route('reports.cash_flow') }}" class="{{ request()->routeIs('reports.cash_flow') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-file-earmark-text"></i></div>
            Arus Kas
        </a>
        @endif

        <div class="sidebar-section">Pengaturan</div>
        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
            <div class="nav-icon"><i class="bi bi-people"></i></div>
            Manajemen User
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
            <div class="user-info">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="role">Administrator</div>
            </div>
        </div>
    </div>
</nav>

<!-- Main Wrapper -->
<div class="main-wrapper">
    <!-- Topbar -->
    <div class="topbar">
        <button class="topbar-btn d-lg-none" onclick="toggleSidebar()" style="border:none;">
            <i class="bi bi-list"></i>
        </button>
        <div>
            <div class="page-title">@yield('page-title', 'Dashboard')</div>
        </div>
        <div class="ms-auto topbar-actions">
            <a href="{{ route('stock.index') }}" class="topbar-btn" title="Stok Gudang">
                <i class="bi bi-archive"></i>
                @if(isset($lowStockCount) && $lowStockCount > 0)
                    <span class="notify-badge">{{ $lowStockCount }}</span>
                @endif
            </a>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm ms-2">
                <i class="bi bi-plus-lg me-1"></i>Transaksi Baru
            </a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="logout-btn ms-2">
                    <i class="bi bi-box-arrow-right"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill text-success"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4 d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-exclamation-triangle-fill text-danger"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
    document.getElementById('sidebarOverlay').classList.toggle('show');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('show');
    document.getElementById('sidebarOverlay').classList.remove('show');
}
</script>
@stack('scripts')
</body>
</html>
