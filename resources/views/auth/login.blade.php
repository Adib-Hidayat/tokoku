<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JMS STORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 70%);
            top: -200px; right: -100px;
            pointer-events: none;
        }
        body::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
            bottom: -100px; left: -100px;
            pointer-events: none;
        }
        .login-card {
            background: rgba(30,41,59,0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            padding: 48px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.4);
            position: relative;
            z-index: 1;
        }
        .brand-icon {
            width: 56px; height: 56px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; color: #fff;
            margin-bottom: 20px;
        }
        h1 { font-size: 1.6rem; font-weight: 700; color: #f1f5f9; margin-bottom: 6px; }
        .subtitle { color: #64748b; font-size: 0.875rem; margin-bottom: 32px; }
        .form-label { font-size: 0.85rem; font-weight: 500; color: #94a3b8; margin-bottom: 6px; }
        .form-control {
            background: rgba(15,23,42,0.6);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            color: #f1f5f9;
            padding: 12px 16px;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        .form-control::placeholder { color: #475569; }
        .form-control:focus {
            background: rgba(15,23,42,0.8);
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
            color: #f1f5f9;
        }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { font-size: 0.8rem; color: #ef4444; }
        .input-group-text {
            background: rgba(15,23,42,0.6);
            border: 1px solid rgba(255,255,255,0.1);
            color: #475569;
            border-radius: 12px 0 0 12px;
        }
        .btn-login {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            border-radius: 12px;
            padding: 13px;
            font-size: 0.95rem;
            font-weight: 600;
            color: #fff;
            width: 100%;
            transition: all 0.2s;
            box-shadow: 0 4px 15px rgba(99,102,241,0.3);
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.4);
            color: #fff;
        }
        .alert-danger {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            border-radius: 12px;
            color: #fca5a5;
            font-size: 0.85rem;
        }
        .show-pwd { cursor: pointer; color: #475569; background: transparent; border: none; }
        .show-pwd:hover { color: #94a3b8; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand-icon"><i class="bi bi-shop-window"></i></div>
        <h1>JMS STORE</h1>
        <p class="subtitle">Sistem Manajemen Terintegrasi & Keuangan</p>

        @if($errors->any())
            <div class="alert alert-danger mb-4">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="admin@toko.com" autocomplete="email" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-5">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="passwordInput"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="••••••••" autocomplete="current-password" required
                        style="border-radius:12px">
                </div>
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
            </button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
