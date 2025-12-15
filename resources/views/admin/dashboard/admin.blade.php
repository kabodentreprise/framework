@extends('Layout')

@section('title', 'Tableau de bord Administrateur')

@section('content')
    <div class="space-y-6">
        
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-indigo-600 to-blue-500 rounded-xl shadow-lg p-6 text-white mb-6">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Bonjour, Mr {{ Auth::user()->prenom }} ! 👋</h1>
                    <p class="text-blue-100">Bienvenue sur votre espace d'administration. Vous avez le contrôle total sur la plateforme.</p>
                </div>
                <div class="mt-4 md:mt-0 bg-white/20 backdrop-blur-sm rounded-full px-4 py-2 flex items-center border border-white/30">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="font-semibold">Administrateur</span>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Users Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl hover:shadow-md transition-shadow duration-300 relative group">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Utilisateurs</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-green-500 flex items-center font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            +{{ $stats['nouveaux_utilisateurs'] ?? 0 }}
                        </span>
                        <span class="text-gray-400 ml-2">inscrits aujourd'hui</span>
                    </div>
                </div>
                <a href="{{ route('admin.utilisateurs.index') }}" class="absolute inset-0 z-10"></a>
            </div>

            <!-- Content Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl hover:shadow-md transition-shadow duration-300 relative group">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4 group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Contenus</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_contenus'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-emerald-500 flex items-center font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ $stats['users_actifs'] ?? 0 }}
                        </span>
                        <span class="text-gray-400 ml-2">utilisateurs actifs</span>
                    </div>
                </div>
                <a href="{{ route('admin.contenus.index') }}" class="absolute inset-0 z-10"></a>
            </div>

            <!-- Pending Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl hover:shadow-md transition-shadow duration-300 relative group">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4 group-hover:bg-yellow-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">En attente</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['pending_content'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        @if(($stats['pending_content'] ?? 0) > 0)
                            <span class="text-red-500 flex items-center font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Action requise
                            </span>
                        @else
                            <span class="text-green-500 flex items-center font-medium">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                À jour
                            </span>
                        @endif
                        <span class="text-gray-400 ml-2">modération</span>
                    </div>
                </div>
                <a href="{{ route('admin.contenus.index') }}" class="absolute inset-0 z-10"></a>
            </div>

            <!-- Comments Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-xl hover:shadow-md transition-shadow duration-300 relative group">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Commentaires</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_commentaires'] ?? 0 }}</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <span class="text-purple-500 flex items-center font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            Total
                        </span>
                        <span class="text-gray-400 ml-2">interactions</span>
                    </div>
                </div>
                <a href="{{ route('admin.commentaires.index') }}" class="absolute inset-0 z-10"></a>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Evolution Users -->
            <div class="bg-white p-6 rounded-xl shadow-sm lg:col-span-2 border border-gray-100">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Évolution des inscriptions</h3>
                </div>
                <div class="h-80 w-full relative">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
            
            <!-- Type Content -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Types de contenus</h3>
                <div class="h-64 relative flex items-center justify-center">
                    <canvas id="contentTypeChart"></canvas>
                </div>
                <div class="mt-4 text-center text-sm text-gray-500">
                    Répartition actuelle des médias
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Actions Rapides</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="{{ route('admin.utilisateurs.create') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-gray-200 hover:bg-blue-50 hover:border-blue-200 hover:text-blue-600 transition group">
                    <div class="p-2 rounded-full bg-blue-100 text-blue-600 mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">Utilisateur</span>
                </a>

                <a href="{{ route('admin.contenus.create') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-gray-200 hover:bg-green-50 hover:border-green-200 hover:text-green-600 transition group">
                    <div class="p-2 rounded-full bg-green-100 text-green-600 mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-green-700">Contenu</span>
                </a>

                <a href="{{ route('admin.regions.create') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-gray-200 hover:bg-yellow-50 hover:border-yellow-200 hover:text-yellow-600 transition group">
                    <div class="p-2 rounded-full bg-yellow-100 text-yellow-600 mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-yellow-700">Région</span>
                </a>

                <a href="{{ route('admin.langues.create') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-gray-200 hover:bg-purple-50 hover:border-purple-200 hover:text-purple-600 transition group">
                    <div class="p-2 rounded-full bg-purple-100 text-purple-600 mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                    </div>
                    <span class="text-sm font-medium text-gray-700 group-hover:text-purple-700">Langue</span>
                </a>
            <a href="{{ route('admin.roles.create') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-gray-200 hover:bg-red-50 hover:border-red-200 hover:text-red-600 transition group">
    <div class="p-2 rounded-full bg-red-100 text-red-600 mb-3 group-hover:scale-110 transition-transform">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0l-3-3m3 3l3-3M6 12h12"/></svg>
    </div>
    <span class="text-sm font-medium text-gray-700 group-hover:text-red-700">Rôle</span>
</a>
<a href="{{ route('admin.medias.create') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-gray-200 hover:bg-indigo-50 hover:border-indigo-200 hover:text-indigo-600 transition group">
    <div class="p-2 rounded-full bg-indigo-100 text-indigo-600 mb-3 group-hover:scale-110 transition-transform">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4h16v16H4V4z"/></svg>
    </div>
    <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-700">Média</span>
</a>
<a href="{{ route('admin.typecontenus.create') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-gray-200 hover:bg-pink-50 hover:border-pink-200 hover:text-pink-600 transition group">
    <div class="p-2 rounded-full bg-pink-100 text-pink-600 mb-3 group-hover:scale-110 transition-transform">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6"/></svg>
    </div>
    <span class="text-sm font-medium text-gray-700 group-hover:text-pink-700">Type Contenu</span>
</a>
<a href="{{ route('admin.type-medias.create') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-gray-200 hover:bg-teal-50 hover:border-teal-200 hover:text-teal-600 transition group">
    <div class="p-2 rounded-full bg-teal-100 text-teal-600 mb-3 group-hover:scale-110 transition-transform">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
    </div>
    <span class="text-sm font-medium text-gray-700 group-hover:text-teal-700">Type Média</span>
</a>
<a href="{{ route('admin.paiements.index') }}" class="flex flex-col items-center justify-center p-4 rounded-lg border border-gray-200 hover:bg-orange-50 hover:border-orange-200 hover:text-orange-600 transition group">
    <div class="p-2 rounded-full bg-orange-100 text-orange-600 mb-3 group-hover:scale-110 transition-transform">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
    </div>
    <span class="text-sm font-medium text-gray-700 group-hover:text-orange-700">Paiements</span>
</a>
</div>
        </div>

        <!-- Activity & System Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800">Activité Récente</h3>
                    <span class="text-xs font-semibold text-blue-600 uppercase">Voir tout</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($recentActivities as $activity)
                        <div class="p-4 hover:bg-gray-50 transition-colors flex items-start">
                            <div class="flex-shrink-0 mr-4">
                                <div class="w-10 h-10 rounded-full bg-{{ $activity['color'] == 'success' ? 'green' : ($activity['color'] == 'warning' ? 'yellow' : 'blue') }}-100 flex items-center justify-center text-{{ $activity['color'] == 'success' ? 'green' : ($activity['color'] == 'warning' ? 'yellow' : 'blue') }}-600">
                                    @if($activity['icon'] == 'person-plus')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                    @elseif($activity['icon'] == 'journal-text')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between">
                                    <h4 class="text-sm font-semibold text-gray-800">{{ $activity['title'] }}</h4>
                                    <span class="text-xs text-gray-400">{{ $activity['time'] }}</span>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $activity['description'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                 <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h3 class="font-bold text-gray-800">État du système</h3>
                    <div class="flex items-center space-x-2">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        <span class="text-xs text-green-600 font-medium">Opérationnel</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4 flex items-center">
                            <div class="p-2 bg-blue-100 text-blue-600 rounded-lg mr-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Base de données</p>
                                <p class="text-sm font-bold text-gray-800">Connectée</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 flex items-center">
                            <div class="p-2 bg-green-100 text-green-600 rounded-lg mr-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Stockage</p>
                                <p class="text-sm font-bold text-gray-800">{{ $stats['storage_used'] ?? '0%' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="text-sm font-bold text-gray-700 mb-3">Métriques globales</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-sm border-b pb-2">
                                <span class="text-gray-500">Total Médias</span>
                                <span class="font-bold text-gray-800">{{ $stats['total_media'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm border-b pb-2">
                                <span class="text-gray-500">Régions couvertes</span>
                                <span class="font-bold text-gray-800">{{ $stats['total_regions'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm border-b pb-2">
                                <span class="text-gray-500">Langues supportées</span>
                                <span class="font-bold text-gray-800">{{ $stats['total_languages'] ?? 0 }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Visites (24h)</span>
                                <span class="font-bold text-gray-800">{{ $stats['today_visits'] ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // --- DATA FROM LARAVEL CONTROLLER ---
        const userGrowthLabels = @json($usersChart['labels']);
        const userGrowthData = @json($usersChart['data']);
        
        const contentTypeLabels = @json($contentChart['labels']);
        const contentTypeData = @json($contentChart['data']);

        // --- CHARTS CONFIG ---
        
        // 1. User Growth Chart
        const userCtx = document.getElementById('userGrowthChart').getContext('2d');
        new Chart(userCtx, {
            type: 'line',
            data: {
                labels: userGrowthLabels,
                datasets: [{
                    label: 'Inscriptions',
                    data: userGrowthData,
                    borderColor: '#4f46e5', // indigo-600
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#4f46e5',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 14 },
                        bodyFont: { size: 13 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [2, 4], color: '#e5e7eb' },
                        ticks: { color: '#6b7280' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6b7280' }
                    }
                }
            }
        });

        // 2. Content Type Chart
        const contentCtx = document.getElementById('contentTypeChart').getContext('2d');
        
        // Dynamic colors generator
        const baseColors = ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899'];
        
        new Chart(contentCtx, {
            type: 'doughnut',
            data: {
                labels: contentTypeLabels,
                datasets: [{
                    data: contentTypeData,
                    backgroundColor: baseColors.slice(0, contentTypeData.length),
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 12 }
                        }
                    }
                },
                cutout: '75%'
            }
        });
    });
</script>
@endsection
