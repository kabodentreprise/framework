@extends('layouts.admin')

@section('title', 'Créer une Région')
@section('page-title', 'Créer une Région')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">Nouvelle Région</h2>
        <p class="text-sm text-gray-500">Ajouter une nouvelle région au système.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gray-50 flex items-center">
            <div class="bg-orange-100 p-2 rounded-lg mr-3">
                <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Informations de la Région</h3>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.regions.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="nom_region" class="block text-sm font-medium text-gray-700 mb-1">Nom de la région <span class="text-red-500">*</span></label>
                        <input type="text" name="nom_region" id="nom_region" value="{{ old('nom_region') }}" required
                               placeholder="Ex: Atlantique" maxlength="255"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('nom_region') border-red-500 @enderror">
                        @error('nom_region') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="localisation" class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
                        <input type="text" name="localisation" id="localisation" value="{{ old('localisation') }}"
                               placeholder="Ex: Sud du Bénin"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('localisation') border-red-500 @enderror">
                        @error('localisation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="population" class="block text-sm font-medium text-gray-700 mb-1">Population (Hab.)</label>
                        <input type="number" name="population" id="population" value="{{ old('population') }}"
                               placeholder="Ex: 1398229"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('population') border-red-500 @enderror">
                        @error('population') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="superficie" class="block text-sm font-medium text-gray-700 mb-1">Superficie (km²)</label>
                        <input type="number" step="0.01" name="superficie" id="superficie" value="{{ old('superficie') }}"
                               placeholder="Ex: 3233"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('superficie') border-red-500 @enderror">
                        @error('superficie') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('description') border-red-500 @enderror"
                              placeholder="Description optionnelle...">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.regions.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                        Créer la région
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
