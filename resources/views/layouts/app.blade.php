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
    <style>
        /* Sidebar */
        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: all 0.3s;
        }
        .sidebar .brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .sidebar .brand a {
            color: #fff;
            text-decoration: none;
            font-size: 1.15rem;
            font-weight: 700;
        }
        .sidebar .nav-menu {
            padding: 1rem 0;
        }
        .sidebar .nav-menu .menu-label {
            color: rgba(255,255,255,0.4);
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.75rem 1.5rem 0.5rem;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.65);
            padding: 0.65rem 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.06);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background: rgba(59, 130, 246, 0.15);
            border-left-color: #3b82f6;
            font-weight: 600;
        }
        .sidebar .nav-link i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.05rem;
        }

        /* Main content */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body class="bg-light">
    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="brand">
            <a href="{{ route('don-nhap.index') }}">
                <i class="bi bi-box-seam me-2"></i>Ngân Giang Tech
            </a>
        </div>
        <nav class="nav-menu">
            <div class="menu-label">Quản lý</div>
            <a class="nav-link {{ request()->routeIs('ncc.*') ? 'active' : '' }}" href="{{ route('ncc.index') }}">
                <i class="bi bi-building"></i> Nhà cung cấp
            </a>
            <a class="nav-link {{ request()->routeIs('don-nhap.*') ? 'active' : '' }}" href="{{ route('don-nhap.index') }}">
                <i class="bi bi-receipt"></i> Đơn nhập hàng
            </a>

            <div class="menu-label">Danh mục</div>
            <a class="nav-link {{ request()->routeIs('loai-hang.*') ? 'active' : '' }}" href="{{ route('loai-hang.index') }}">
                <i class="bi bi-tags"></i> Loại hàng
            </a>
            <a class="nav-link {{ request()->routeIs('mat-hang.*') ? 'active' : '' }}" href="{{ route('mat-hang.index') }}">
                <i class="bi bi-box"></i> Mặt hàng
            </a>
        </nav>
    </aside>

    {{-- Main content --}}
    <div class="main-content">
        {{-- Top bar --}}
        <div class="bg-white border-bottom px-4 py-2 d-flex justify-content-between align-items-center">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('don-nhap.index') }}" class="text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item active">@yield('title')</li>
                </ol>
            </nav>
        </div>

        {{-- Flash messages + Content --}}
        <div class="container-fluid px-4 py-4 flex-grow-1">
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

        {{-- Footer --}}
        <footer class="bg-white py-3 border-top mt-auto">
            <div class="container-fluid text-center text-secondary small">
                &copy; {{ date('Y') }} Ngân Giang Tech. Technical Test Project.
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
