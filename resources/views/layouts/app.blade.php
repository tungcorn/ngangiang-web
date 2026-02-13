<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Quản lý Nhập Hàng') - Ngân Giang Tech</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <!-- Navbar: Trắng, đổ bóng nhẹ -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ route('don-nhap.index') }}">
                <i class="bi bi-box-seam me-2"></i>Ngân Giang Tech
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('don-nhap.index') ? 'active fw-bold text-primary' : '' }}" href="{{ route('don-nhap.index') }}">
                            <i class="bi bi-list-ul me-1"></i> Danh sách Đơn nhập
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('don-nhap.create') ? 'active fw-bold text-primary' : '' }}" href="{{ route('don-nhap.create') }}">
                            <i class="bi bi-plus-circle me-1"></i> Tạo đơn mới
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content: Tự động giãn cách để đẩy footer xuống -->
    <div class="container py-4 flex-grow-1">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Footer: Trắng, viền trên -->
    <footer class="bg-white py-3 border-top mt-auto">
        <div class="container text-center text-secondary small">
            &copy; {{ date('Y') }} Ngân Giang Tech. Technical Test Project.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
