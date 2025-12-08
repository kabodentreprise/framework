@extends('layouts.admin')

@section('title', 'Modifier un Type de Média')
@section('page-title', 'Modifier un Type de Média')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Modifier le Type de Média</h2>
            <a href="{{ route('admin.type-medias.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        <form action="{{ route('admin.type-medias.update', $typeMedia->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="nom_media" class="block text-sm font-medium text-gray-700 mb-2">Nom du type de média</label>
                <input type="text" 
                       name="nom_media" 
                       id="nom_media" 
                       class="w-full rounded-lg border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors"
                       value="{{ old('nom_media', $typeMedia->nom_media) }}" 
                       required>
                @error('nom_media')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 mt-8 border-t pt-6">
                <a href="{{ route('admin.type-medias.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition-colors">
                    Annuler
                </a>
                <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-medium transition-colors shadow-sm">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
