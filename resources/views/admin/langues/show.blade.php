@extends('layouts.admin')

@section('title', 'Détails Langue')
@section('page-title', 'Détails de la Langue')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="h-16 w-16 rounded-2xl bg-orange-600 flex items-center justify-center shadow-lg shadow-orange-600/20 text-white text-2xl font-bold tracking-wider uppercase border-4 border-white ring-1 ring-gray-100">
                {{ $langue->code_langue }}
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $langue->nom_langue }}</h1>
                <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                        ID: <span class="font-mono text-gray-700 font-semibold">#{{ $langue->id }}</span>
                    </span>
                    <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Code ISO: <span class="font-semibold text-gray-700 uppercase">{{ $langue->code_langue }}</span>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.langues.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 font-medium hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                Retour
            </a>
            <a href="{{ route('admin.langues.edit', $langue->id) }}" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl font-medium shadow-md shadow-orange-500/20 hover:from-orange-600 hover:to-orange-700 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content (2/3) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description Card -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                    À propos
                </h3>
                <div class="prose prose-orange max-w-none">
                    @if($langue->description)
                        <p class="text-gray-600 leading-relaxed text-lg">{{ $langue->description }}</p>
                    @else
                        <div class="bg-gray-50 rounded-xl p-6 text-center border-2 border-dashed border-gray-200">
                            <p class="text-gray-400 italic mb-2">Aucune description disponible.</p>
                            <a href="{{ route('admin.langues.edit', $langue->id) }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                                + Ajouter une description
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stats/Metrics (Mockup) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 group hover:shadow-md transition-all duration-300">
                    <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Utilisateurs</p>
                        <p class="text-2xl font-bold text-gray-900">--</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-4 group hover:shadow-md transition-all duration-300">
                    <div class="h-12 w-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Contenus</p>
                        <p class="text-2xl font-bold text-gray-900">--</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar (1/3) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Meta Info Card -->
            <div class="bg-gray-900 rounded-2xl p-6 shadow-lg text-white relative overflow-hidden">
                <!-- Background Pattern -->
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 rounded-full bg-gray-800 opacity-50 blur-xl"></div>
                
                <h3 class="text-lg font-bold mb-6 relative z-10">Méta-informations</h3>
                
                <div class="space-y-6 relative z-10">
                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-gray-800 rounded-lg">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Date de création</p>
                            <p class="font-medium mt-1">{{ $langue->created_at->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $langue->created_at->format('H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-2 bg-gray-800 rounded-lg">
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Dernière modification</p>
                            <p class="font-medium mt-1">{{ $langue->updated_at->format('d/m/Y') }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">{{ $langue->updated_at->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50 rounded-2xl p-6 border border-red-100">
                <h3 class="text-red-800 font-bold mb-2">Zone de danger</h3>
                <p class="text-red-600 text-sm mb-4">Cette action est irréversible. Assurez-vous qu'aucun utilisateur n'utilise cette langue.</p>
                
                <form action="{{ route('admin.langues.destroy', $langue->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette langue ? Cette action est irréversible.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border border-red-200 shadow-sm text-sm font-medium rounded-xl text-red-700 bg-white hover:bg-red-50 hover:border-red-300 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Supprimer la langue
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
