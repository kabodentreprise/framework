@extends('layouts.admin')

@section('title', 'Modifier Région')
@section('page-title', 'Modifier la Région')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-lg shadow-orange-500/20 text-white">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Modifier {{ $region->nom_region }}</h1>
                <p class="text-sm text-gray-500">Mettez à jour les informations de la région.</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.regions.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 font-medium hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                Annuler
            </a>
            <button form="edit-region-form" type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-xl font-medium shadow-lg shadow-orange-600/20 hover:bg-orange-700 hover:shadow-orange-600/30 transition-all flex items-center gap-2 transform active:scale-95">
                <span>Enregistrer</span>
                <svg class="w-4 h-4 text-orange-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form (2/3) -->
        <div class="lg:col-span-2">
            <form id="edit-region-form" action="{{ route('admin.regions.update', $region->id) }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @csrf
                @method('PUT')

                <div class="p-8 space-y-8">
                    <!-- Identity Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Identité de la région
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="group">
                                <label for="nom_region" class="block text-sm font-medium text-gray-700 mb-1.5 transition-colors group-focus-within:text-orange-600">Nom de la région</label>
                                <input type="text" name="nom_region" id="nom_region" value="{{ old('nom_region', $region->nom_region) }}" required maxlength="255"
                                       class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-gray-900 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-3 px-4 transition-all @error('nom_region') border-red-300 bg-red-50 text-red-900 @enderror"
                                       placeholder="Ex: Atlantique">
                                @error('nom_region') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="group">
                                <label for="localisation" class="block text-sm font-medium text-gray-700 mb-1.5 transition-colors group-focus-within:text-orange-600">Localisation</label>
                                <input type="text" name="localisation" id="localisation" value="{{ old('localisation', $region->localisation) }}"
                                       class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-gray-900 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-3 px-4 transition-all @error('localisation') border-red-300 bg-red-50 text-red-900 @enderror"
                                       placeholder="Ex: Sud du Bénin">
                                @error('localisation') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <div class="group">
                                <label for="population" class="block text-sm font-medium text-gray-700 mb-1.5 transition-colors group-focus-within:text-orange-600">Population (Hab.)</label>
                                <input type="number" name="population" id="population" value="{{ old('population', $region->population) }}"
                                       class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-gray-900 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-3 px-4 transition-all @error('population') border-red-300 bg-red-50 text-red-900 @enderror"
                                       placeholder="Ex: 1398229">
                                @error('population') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="group">
                                <label for="superficie" class="block text-sm font-medium text-gray-700 mb-1.5 transition-colors group-focus-within:text-orange-600">Superficie (km²)</label>
                                <input type="number" step="0.01" name="superficie" id="superficie" value="{{ old('superficie', $region->superficie) }}"
                                       class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-gray-900 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-3 px-4 transition-all @error('superficie') border-red-300 bg-red-50 text-red-900 @enderror"
                                       placeholder="Ex: 3233">
                                @error('superficie') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <hr class="border-gray-100">

                    <!-- Description Section -->
                    <div class="group">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2 transition-colors group-focus-within:text-orange-600">Description détaillée</label>
                        <textarea name="description" id="description" rows="5"
                                  class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-gray-900 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-4 transition-all resize-none @error('description') border-red-300 bg-red-50 @enderror"
                                  placeholder="Description de la région...">{{ old('description', $region->description) }}</textarea>
                        @error('description') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs text-gray-500 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Les champs marqués d'une astérisque sont obligatoires.
                    </span>
                </div>
            </form>
        </div>

        <!-- Sidebar Options (1/3) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Context Card -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-6 shadow-lg text-white">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Statut rapide
                </h3>
                <div class="space-y-4 text-sm text-gray-300">
                    <div class="flex justify-between items-center pb-2 border-b border-gray-700">
                        <span>Créé le</span>
                        <span class="font-mono text-white">{{ $region->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-700">
                        <span>Dernière édit.</span>
                        <span class="font-mono text-white">{{ $region->updated_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>ID Interne</span>
                        <span class="bg-gray-700 px-2 py-0.5 rounded text-white text-xs font-mono">#{{ $region->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
