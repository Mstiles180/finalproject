<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - {{ config('app.name', 'Work Connect') }} - @yield('title', 'Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f5f7fb; }
        .admin-sidebar {
            min-height: 100vh;
            background: #0f172a;
            color: #e5e7eb;
            position: sticky;
            top: 0;
        }
        .admin-sidebar .nav-link { color: #cbd5e1; border-radius: .5rem; }
        .admin-sidebar .nav-link.active, .admin-sidebar .nav-link:hover {
            background: #111827; color: #fff;
        }
        .admin-header { background: #111827; color: #fff; }
        .admin-card { border: none; box-shadow: 0 4px 16px rgba(2,6,23,.08); border-radius: .75rem; }
        .badge-soft { background: rgba(99,102,241,.12); color: #6366f1; }
        .btn-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: none; color: #fff;
        }
        .btn-gradient:hover { filter: brightness(.95); }
        .content-wrapper { padding: 24px; }
        .section-title { font-weight: 600; color: #334155; }
    </style>
    @yield('styles')
    @stack('styles')
    <script>
        function setActiveLink() {
            const path = window.location.pathname;
            document.querySelectorAll('.admin-sidebar .nav-link').forEach(a => {
                if (a.getAttribute('href') && path.startsWith(a.getAttribute('href'))) {
                    a.classList.add('active');
                }
            });
        }
        document.addEventListener('DOMContentLoaded', setActiveLink);
    </script>
    @stack('head')
</head>
<body>
    <header class="admin-header py-3 mb-0">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ url('/') }}" class="text-decoration-none text-white d-flex align-items-center">
                        <i class="fas fa-handshake me-2"></i>
                        <strong>{{ config('app.name', 'Work Connect') }}</strong>
                    </a>
                    <span class="badge badge-soft ms-3">Admin Panel</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="text-white-50 text-decoration-none">User Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-light">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <aside class="col-12 col-md-3 col-lg-2 admin-sidebar p-3">
                <nav class="nav flex-column gap-1">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fas fa-gauge me-2"></i>Dashboard</a>
                    <div class="mt-3 mb-1 text-uppercase small text-secondary">Management</div>
                    <a class="nav-link" href="{{ route('admin.users') }}"><i class="fas fa-users me-2"></i>Users</a>
                    <a class="nav-link" href="{{ route('admin.jobs') }}"><i class="fas fa-briefcase me-2"></i>Jobs</a>
                    <a class="nav-link" href="{{ route('admin.offers') }}"><i class="fas fa-envelope-open-text me-2"></i>Offers</a>
                    <a class="nav-link" href="{{ route('admin.pickup-points') }}"><i class="fas fa-location-dot me-2"></i>Pickup Points</a>
                    <div class="mt-3 mb-1 text-uppercase small text-secondary">Administrative</div>
                    <a class="nav-link" href="{{ route('admin.provinces') }}"><i class="fas fa-map me-2"></i>Provinces</a>
                    <a class="nav-link" href="{{ route('admin.districts') }}"><i class="fas fa-map-location me-2"></i>Districts</a>
                    <a class="nav-link" href="{{ route('admin.sectors') }}"><i class="fas fa-diagram-project me-2"></i>Sectors</a>
                    <a class="nav-link" href="{{ route('admin.cells') }}"><i class="fas fa-table-cells-large me-2"></i>Cells</a>
                    <a class="nav-link" href="{{ route('admin.villages') }}"><i class="fas fa-tree-city me-2"></i>Villages</a>
                    <div class="mt-3 mb-1 text-uppercase small text-secondary">Moderation</div>
                    <a class="nav-link" href="{{ route('admin.verifications') }}"><i class="fas fa-badge-check me-2"></i>Verifications</a>
                    <a class="nav-link" href="{{ route('admin.reports') }}"><i class="fas fa-flag me-2"></i>Reports</a>
                    <div class="mt-3 mb-1 text-uppercase small text-secondary">Taxonomy</div>
                    <a class="nav-link" href="{{ route('admin.categories') }}"><i class="fas fa-tags me-2"></i>Categories</a>
                    <a class="nav-link" href="{{ route('admin.skills') }}"><i class="fas fa-wrench me-2"></i>Skills</a>
                    <div class="mt-3 mb-1 text-uppercase small text-secondary">Exports</div>
                    <a class="nav-link" href="{{ route('admin.export.users') }}"><i class="fas fa-file-export me-2"></i>Export Users</a>
                    <a class="nav-link" href="{{ route('admin.export.jobs') }}"><i class="fas fa-file-export me-2"></i>Export Jobs</a>
                    <a class="nav-link" href="{{ route('admin.export.offers') }}"><i class="fas fa-file-export me-2"></i>Export Offers</a>
                </nav>
            </aside>
            <section class="col-12 col-md-9 col-lg-10 content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </section>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
    @stack('scripts')
</body>
</html>


