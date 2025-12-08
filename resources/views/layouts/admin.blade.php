<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'Culture Bénin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900" x-data="{ sidebarOpen: false }">

    <!-- Mobile Header -->
    <div class="flex items-center justify-between bg-white px-4 py-3 shadow-sm md:hidden fixed w-full z-20 top-0 left-0">
        <div class="font-bold text-xl text-orange-600">Culture Bénin</div>
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div class="flex h-screen overflow-hidden pt-14 md:pt-0">

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed z-30 inset-y-0 left-0 w-64 bg-white border-r border-gray-200 transition-transform duration-300 md:relative md:translate-x-0 overflow-y-auto">
            <div class="flex items-center justify-center h-16 border-b border-gray-100 mb-6 bg-white">
                <span class="text-2xl font-bold text-gray-800">Culture<span class="text-orange-600">Bénin</span></span>
            </div>

            <nav class="px-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('dashboard') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Tableau de bord
                </a>

                @auth
                    @if(Auth::user()->isAdmin())
                        <div class="pt-4 pb-2">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Administration</p>
                        </div>

                        <a href="{{ route('admin.utilisateurs.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.utilisateurs.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.utilisateurs.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            Utilisateurs
                        </a>

                        <a href="{{ route('admin.roles.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.roles.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.roles.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Rôles & Permissions
                        </a>

                        <a href="{{ route('admin.contenus.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.contenus.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.contenus.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            Contenus
                        </a>

                        <a href="{{ route('admin.commentaires.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.commentaires.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.commentaires.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Commentaires
                        </a>

                        <a href="{{ route('admin.medias.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.medias.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.medias.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Médiathèque
                        </a>

                        <a href="{{ route('admin.regions.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.regions.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.regions.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Régions
                        </a>

                        <a href="{{ route('admin.langues.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.langues.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.langues.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                            </svg>
                            Langues
                        </a>

                        <a href="{{ route('admin.typecontenus.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.typecontenus.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.typecontenus.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Types de Contenu
                        </a>

                        <a href="{{ route('admin.type-medias.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.type-medias.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.type-medias.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                            </svg>
                            Types de Média
                        </a>

                         <a href="{{ route('admin.paiements.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.paiements.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.paiements.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Paiements
                        </a>
                    @endif

                    @if(Auth::user()->canModerate() && !Auth::user()->isAdmin())
                        <div class="pt-4 pb-2">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Modération</p>
                        </div>
                        
                        <a href="{{ route('admin.contenus.index') }}" class="flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.contenus.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <div class="flex items-center">
                                <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.contenus.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Contenus à valider
                            </div>
                            @if($pendingCount = \App\Models\Contenus::where('statut', 'en_attente')->count())
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                    {{ $pendingCount }}
                                </span>
                            @endif
                        </a>
                        
                        <a href="{{ route('admin.commentaires.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.commentaires.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.commentaires.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Commentaires
                        </a>
                    @endif

                    @if(Auth::user()->canContribute())
                         <div class="pt-4 pb-2">
                            <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Contribution</p>
                        </div>

                         <a href="{{ route('admin.contenus.create') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.contenus.create') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.contenus.create') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Créer un contenu
                        </a>
                        
                        @if(!Auth::user()->isAdmin())
                        <a href="{{ route('admin.medias.index') }}" class="flex items-center px-4 py-2.5 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('admin.medias.*') ? 'bg-orange-50 text-orange-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('admin.medias.*') ? 'text-orange-500' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Médiathèque
                        </a>
                        @endif
                    @endif
                @endauth
            </nav>
        </aside>

        <!-- Wrapper for Navbar + Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            
            <!-- Top Navbar (Desktop only, Mobile is handled by header above) -->
            <header class="hidden md:flex items-center justify-between px-8 py-4 bg-white border-b border-gray-100">
                <div class="font-semibold text-gray-800 text-lg">
                    Administrateur
                </div>
                
                <!-- User Menu -->
                <div class="flex items-center gap-4">
                     <div class="text-right mr-2">
                        <div class="text-sm font-bold text-gray-800">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->role->nom_role ?? 'Utilisateur' }}</div>
                    </div>
                    <div class="relative" x-data="{ open: false }">
                         <button @click="open = !open" class="flex items-center focus:outline-none">
                            @if(Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover border-2 border-orange-100">
                            @else
                                <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold border-2 border-orange-200">
                                    {{ strtoupper(substr(Auth::user()->prenom, 0, 1)) }}
                                </div>
                            @endif
                        </button>
                        
                        <!-- Dropdown -->
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50" style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-700">Mon Profil</a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 md:p-8">
                <div class="max-w-7xl mx-auto">
                     @if (!request()->routeIs('dashboard'))
                        <!-- Header of the page (only if not dashboard, as dashboard has its own style) -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">@yield('title')</h1>
                                <p class="text-gray-500 text-sm mt-1">@yield('page-title')</p>
                            </div>
                            <div class="flex items-center gap-3">
                                @yield('page-actions')
                            </div>
                        </div>
                    @endif

                    <!-- Alerts -->
                    @include('partials.alerts')

                    <!-- Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    
    @stack('scripts')
</body>
</html>
