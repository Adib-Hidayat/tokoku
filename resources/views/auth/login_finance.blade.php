<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Login - JMS STORE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        }
        .login-box {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
            border-top: 5px solid #0ea5e9;
        }
        .brand {
            text-align: center;
            margin-bottom: 30px;
        }
        .brand i {
            font-size: 3rem;
            color: #0ea5e9;
        }
        .brand h2 {
            font-weight: 700;
            color: #1e293b;
            margin-top: 10px;
        }
        .btn-primary {
            background-color: #0ea5e9;
            border: none;
            padding: 12px;
            font-weight: 600;
            border-radius: 10px;
        }
        .btn-primary:hover {
            background-color: #0284c7;
        }
        .form-control {
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="brand">
            <i class="bi bi-bank"></i>
            <h2>JMS FINANCE</h2>
            <p class="text-muted small">Financial Management System Access</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger small">{{ $errors->first() }}</div>
        @endif

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label text-muted small fw-bold">EMAIL ADDRESS</label>
                <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-muted small fw-bold">PASSWORD</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                <i class="bi bi-shield-lock me-2"></i>SECURE LOGIN
            </button>
        </form>
        <div class="mt-4 text-center">
            <a href="{{ url('/login') }}" class="text-decoration-none small text-muted">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Kasir Login
            </a>
        </div>
    </div>
</body>
</html>
