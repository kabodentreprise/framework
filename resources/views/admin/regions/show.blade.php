@extends('layouts.admin')

@section('title', 'Détails Région')
@section('page-title', 'Détails de la Région')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="h-16 w-16 rounded-2xl bg-orange-600 flex items-center justify-center shadow-lg shadow-orange-600/20 text-white text-2xl font-bold tracking-wider uppercase border-4 border-white ring-1 ring-gray-100">
                {{ substr($region->nom_region, 0, 2) }}
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $region->nom_region }}</h1>
                <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                        </svg>
                        ID: <span class="font-mono text-gray-700 font-semibold">#{{ $region->id }}</span>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.regions.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 font-medium hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                Retour
            </a>
            <a href="{{ route('admin.regions.edit', $region->id) }}" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl font-medium shadow-md shadow-orange-500/20 hover:from-orange-600 hover:to-orange-700 transition-all flex items-center gap-2">
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
                    @if($region->description)
                        <p class="text-gray-600 leading-relaxed text-lg">{{ $region->description }}</p>
                    @else
                        <div class="bg-gray-50 rounded-xl p-6 text-center border-2 border-dashed border-gray-200">
                            <p class="text-gray-400 italic mb-2">Aucune description disponible.</p>
                            <a href="{{ route('admin.regions.edit', $region->id) }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                                + Ajouter une description
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Stats/Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Population -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center group hover:shadow-md transition-all duration-300">
                    <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Population</p>
                    <p class="text-xl font-bold text-gray-900">{{ number_format($region->population, 0, ',', ' ') }} <span class="text-xs font-normal text-gray-400">hab.</span></p>
                </div>
                
                <!-- Superficie -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center group hover:shadow-md transition-all duration-300">
                    <div class="h-12 w-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.553-.894L15 4m0 13V4m0 0L9 7" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Superficie</p>
                    <p class="text-xl font-bold text-gray-900">{{ number_format($region->superficie, 2, ',', ' ') }} <span class="text-xs font-normal text-gray-400">km²</span></p>
                </div>

                <!-- Localisation -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center group hover:shadow-md transition-all duration-300">
                    <div class="h-12 w-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Localisation</p>
                    <p class="text-lg font-bold text-gray-900 truncate w-full" title="{{ $region->localisation }}">{{ $region->localisation ?? 'N/A' }}</p>
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
                            <p class="font-medium mt-1">{{ $region->created_at->format('d/m/Y') }}</p>
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
                            <p class="font-medium mt-1">{{ $region->updated_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50 rounded-2xl p-6 border border-red-100">
                <h3 class="text-red-800 font-bold mb-2">Zone de danger</h3>
                <p class="text-red-600 text-sm mb-4">Cette action est irréversible.</p>
                
                <form action="{{ route('admin.regions.destroy', $region->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette région ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border border-red-200 shadow-sm text-sm font-medium rounded-xl text-red-700 bg-white hover:bg-red-50 hover:border-red-300 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Supprimer la région
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
