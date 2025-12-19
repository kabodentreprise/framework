<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">

    <title>@yield('title', 'Culture Bénin') - Plateforme Culturelle</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=source-sans-3:400,600" rel="stylesheet" />

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.min.css') }}">

    @stack('styles')
    @vite(['resources/css/app.css'])
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header -->
        <nav class="app-header navbar navbar-expand bg-white shadow-sm border-bottom">
            <div class="container-fluid">
                <!-- Sidebar Toggle -->
                <button class="navbar-toggler border-0 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar">
                    <i class="bi bi-list fs-4"></i>
                </button>

                <!-- Role Display -->
                <div class="d-none d-md-block">
                    <span class="navbar-text text-dark">
                        <i class="bi bi-person-badge me-1"></i>
                        @auth
                            {{ Auth::user()->getRoleName() }}
                        @else
                            Visiteur
                        @endauth
                    </span>
                </div>

                <!-- User Menu -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
                            <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('adminlte/img/default-avatar.png') }}"
                                 class="rounded-circle me-2" width="32" height="32" alt="Avatar">
                            <span class="d-none d-md-inline">
                                {{ Auth::user()->prenom ?? 'Utilisateur' }}
                            </span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">
                                    {{ Auth::user()->getFullName() }}
                                    <small class="d-block text-muted">{{ Auth::user()->getRoleName() }}</small>
                                </h6>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person me-2"></i>Mon profil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-gear me-2"></i>Paramètres
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>Déconnexion
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside class="app-sidebar bg-white shadow border-end" id="sidebar">
            <div class="sidebar-brand p-3 border-bottom">
                <a href="{{ route('dashboard') }}" class="brand-link text-decoration-none">
                    <img src="{{ asset('adminlte/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image opacity-75 me-2" height="30">
                    <span class="brand-text fw-semibold text-dark">Culture Bénin</span>
                </a>
            </div>

            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <!-- Dashboard -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-speedometer2 text-primary"></i>
                                <p>Tableau de bord</p>
                            </a>
                        </li>

                        <!-- Bibliothèque (Visible pour tous les authentifiés) -->
                        <li class="nav-item">
                            <a href="{{ route('bibliotheque.index') }}" class="nav-link {{ request()->routeIs('bibliotheque.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-collection-play text-info"></i>
                                <p>Ma Bibliothèque</p>
                            </a>
                        </li>

                        @auth
                            <!-- Administration Section (Admin only) -->
                            @if(Auth::user()->isAdmin())
                                <li class="nav-header text-uppercase text-muted small fw-bold mt-3 mb-1 px-3">
                                    <i class="bi bi-shield-check me-1"></i> Administration
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.utilisateurs.index') }}" class="nav-link {{ request()->routeIs('admin.utilisateurs.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-people text-primary"></i>
                                        <p>Utilisateurs</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-shield text-success"></i>
                                        <p>Rôles & Permissions</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.langues.index') }}" class="nav-link {{ request()->routeIs('admin.langues.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-translate text-info"></i>
                                        <p>Langues</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.regions.index') }}" class="nav-link {{ request()->routeIs('admin.regions.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-geo-alt text-warning"></i>
                                        <p>Régions</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.paiements.index') }}" class="nav-link {{ request()->routeIs('admin.paiements.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-currency-dollar text-success"></i>
                                        <p>Paiements</p>
                                    </a>
                                </li>
                            @endif

                            <!-- Moderation Section (Admin & Moderator) -->
                            @if(Auth::user()->canModerate())
                                <li class="nav-header text-uppercase text-muted small fw-bold mt-3 mb-1 px-3">
                                    <i class="bi bi-clipboard-check me-1"></i> Modération
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.contenus.index') }}" class="nav-link {{ request()->routeIs('admin.contenus.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-clock-history text-warning"></i>
                                        <p>Contenus</p>
                                        @if($pendingCount = \App\Models\Contenus::where('statut', 'en_attente')->count())
                                            <span class="badge bg-danger float-end">{{ $pendingCount }}</span>
                                        @endif
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.commentaires.index') }}" class="nav-link {{ request()->routeIs('admin.commentaires.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-flag text-danger"></i>
                                        <p>Commentaires</p>
                                    </a>
                                </li>
                            @endif

                            <!-- Content Management Section (Contributors & above) -->
                            @if(Auth::user()->canContribute())
                                <li class="nav-header text-uppercase text-muted small fw-bold mt-3 mb-1 px-3">
                                    <i class="bi bi-pencil-square me-1"></i> Contribution
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.contenus.create') }}" class="nav-link {{ request()->routeIs('admin.contenus.create') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-plus-circle text-success"></i>
                                        <p>Créer un contenu</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('admin.medias.index') }}" class="nav-link {{ request()->routeIs('admin.medias.*') ? 'active' : '' }}">
                                        <i class="nav-icon bi bi-images text-purple"></i>
                                        <p>Médiathèque</p>
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </nav>
            </div>

            <!-- Sidebar Footer -->
            <div class="sidebar-footer border-top p-3">
                <small class="text-muted">
                    Culture Bénin &copy; {{ date('Y') }}<br>
                    <span class="text-xs">v{{ config('app.version', '1.0.0') }}</span>
                </small>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="app-main">
            <!-- Page Header -->
            <div class="app-content-header bg-white border-bottom shadow-sm py-3">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <div class="col">
                            <h1 class="h3 mb-0">@yield('page-title', 'Tableau de bord')</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    @yield('breadcrumbs')
                                </ol>
                            </nav>
                        </div>
                        <div class="col-auto">
                            @yield('page-actions')
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="app-content">
                <div class="container-fluid py-4">
                    @include('partials.alerts')
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="app-footer bg-white border-top py-3">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <strong>Culture Bénin</strong> &copy; {{ date('Y') }}
                        - Plateforme de promotion culturelle et linguistique
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="text-muted">
                            <i class="bi bi-clock"></i> {{ now()->format('d/m/Y H:i') }}
                        </span>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"></script>
    <script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>

    @stack('scripts')
    @vite(['resources/js/app.js'])

    <!-- Initialize components -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Auto-dismiss alerts after 5 seconds
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
                alerts.forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>
</html>
