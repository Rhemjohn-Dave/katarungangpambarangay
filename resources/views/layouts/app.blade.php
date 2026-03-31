<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Katarungang Pambarangay') — Case Management System</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #3855a5;
            --primary-dark: #2c4589;
            --primary-light: #4e6ec0;
            --sidebar-width: 260px;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary) 0%, var(--primary-dark) 100%);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        #sidebar .sidebar-brand {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        }

        #sidebar .sidebar-brand h6 {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin: 0;
        }

        #sidebar .sidebar-brand h5 {
            color: #fff;
            font-size: 1rem;
            font-weight: 700;
            margin: 0.2rem 0 0;
            line-height: 1.3;
        }

        #sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            margin: 2px 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.18);
        }

        #sidebar .nav-link i {
            font-size: 1rem;
            width: 1.2rem;
            text-align: center;
        }

        #sidebar .nav-section-title {
            color: rgba(255, 255, 255, 0.45);
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 1rem 1.25rem 0.3rem;
            font-weight: 600;
        }

        /* ── Main content ── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Top navbar ── */
        #topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
        }

        /* ── Content area ── */
        .content-area {
            padding: 1.75rem 1.5rem;
            flex: 1;
        }

        /* ── Cards ── */
        .stat-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .stat-card .card-icon {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        /* ── Page header ── */
        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h4 {
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .page-header p {
            color: #64748b;
            font-size: 0.875rem;
            margin: 0.25rem 0 0;
        }

        /* ── Table ── */
        .table-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        .table th {
            background-color: #f8fafc;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }

        /* ── Forms ── */
        .form-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        }

        .form-label {
            font-weight: 500;
            font-size: 0.875rem;
            color: #374151;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(56, 85, 165, 0.15);
        }

        /* ── Buttons ── */
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        /* ── Badge roles ── */
        .badge-admin {
            background-color: var(--primary);
        }

        .badge-staff {
            background-color: #10b981;
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #main-content {
                margin-left: 0;
            }
        }

        /* ── Scrollbar ── */
        #sidebar::-webkit-scrollbar {
            width: 4px;
        }

        #sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        /* ── User avatar ── */
        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- ════════ SIDEBAR ════════ -->
    <div id="sidebar">
        <div class="sidebar-brand">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('brgylogo.jpg') }}" alt="Barangay Logo" style="width:46px;height:46px;border-radius:50%;object-fit:cover;
                        border:2px solid rgba(255,255,255,0.4);flex-shrink:0;">
                <div>
                    <h6 class="mb-0">Katarungang<br>Pambarangay</h6>
                    <h5 class="mb-0">Brgy. Zone 12-A</h5>
                    <h5 class="mb-0">Talisay City</h5>

                </div>
            </div>
        </div>

        <nav class="mt-2 pb-4">
            <span class="nav-section-title">Main</span>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <span class="nav-section-title">Case Records</span>
            <a href="{{ route('cases.index') }}" class="nav-link {{ request()->routeIs('cases.*') ? 'active' : '' }}">
                <i class="bi bi-folder2-open"></i> All Cases
            </a>
            <a href="{{ route('cases.create') }}"
                class="nav-link {{ request()->routeIs('cases.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle"></i> Add New Case
            </a>

            @if(auth()->user()->isAdmin())
                <span class="nav-section-title">Administration</span>
                <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> User Management
                </a>
                <a href="{{ route('users.create') }}" class="nav-link">
                    <i class="bi bi-person-plus"></i> Add User
                </a>
            @endif

            <span class="nav-section-title">Account</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link w-100 text-start border-0"
                    style="background:none;cursor:pointer;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </nav>
    </div>
    <!-- ════════ END SIDEBAR ════════ -->

    <!-- ════════ MAIN CONTENT ════════ -->
    <div id="main-content">

        <!-- Top Navbar -->
        <div id="topbar" class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light d-md-none" id="sidebarToggle">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="d-none d-sm-block">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 small">
                            <li class="breadcrumb-item text-muted">
                                <i class="bi bi-house-door"></i> Home
                            </li>
                            <li class="breadcrumb-item active text-dark fw-semibold">
                                @yield('breadcrumb', 'Dashboard')
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <div class="dropdown">
                    <button class="btn btn-light d-flex align-items-center gap-2 border-0 rounded-pill px-3"
                        type="button" data-bs-toggle="dropdown">
                        <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <div class="d-none d-sm-block text-start">
                            <div class="fw-semibold small lh-1">{{ auth()->user()->name }}</div>
                            <div class="text-muted" style="font-size:0.7rem;">
                                {{ ucfirst(auth()->user()->role) }}
                            </div>
                        </div>
                        <i class="bi bi-chevron-down small text-muted"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li>
                            <span class="dropdown-item-text small text-muted">
                                {{ auth()->user()->email }}
                            </span>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-1">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- End Top Navbar -->

        <!-- Content Area -->
        <div class="content-area">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-3"
                    role="alert">
                    <i class="bi bi-check-circle-fill"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-3"
                    role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
        <!-- End Content Area -->

    </div>
    <!-- ════════ END MAIN CONTENT ════════ -->

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar mobile toggle
        document.getElementById('sidebarToggle')?.addEventListener('click', function () {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Auto-dismiss alerts after 4s
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(el => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
                bsAlert.close();
            });
        }, 4000);
    </script>
    @stack('scripts')
</body>

</html>