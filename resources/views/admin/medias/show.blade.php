@extends('layouts.admin')

@section('title', 'Détails du Média')
@section('page-title', 'Détails du Média')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="h-16 w-16 rounded-2xl bg-orange-600 flex items-center justify-center shadow-lg shadow-orange-600/20 text-white text-2xl font-bold tracking-wider uppercase border-4 border-white ring-1 ring-gray-100">
                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Média #{{ $media->id }}</h1>
                <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Type: <span class="font-semibold text-gray-700 ml-1">{{ $media->typeMedia->nom_media ?? 'Inconnu' }}</span>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.medias.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 font-medium hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                Retour
            </a>
            <a href="{{ route('admin.medias.edit', $media->id) }}" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl font-medium shadow-md shadow-orange-500/20 hover:from-orange-600 hover:to-orange-700 transition-all flex items-center gap-2">
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
            <!-- File Preview/Info -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Aperçu
                </h3>
                
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200 flex flex-col items-center justify-center">
                    @php
                        $extension = pathinfo($media->chemin, PATHINFO_EXTENSION);
                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                    @endphp

                    @if($isImage)
                        <img src="{{ asset('storage/' . $media->chemin) }}" alt="Aperçu" class="max-h-96 w-auto rounded-lg shadow-sm">
                    @else
                        <div class="text-6xl text-gray-400 mb-4">
                            <svg class="w-24 h-24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <p class="text-lg font-medium text-gray-700">{{ basename($media->chemin) }}</p>
                        <a href="{{ asset('storage/' . $media->chemin) }}" target="_blank" class="mt-4 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">
                            Télécharger / Voir le fichier
                        </a>
                    @endif
                </div>

                @if($media->description)
                <div class="mt-6">
                    <h4 class="font-bold text-gray-800 mb-2">Description</h4>
                    <p class="text-gray-600 bg-gray-50 p-4 rounded-lg border border-gray-100">
                        {{ $media->description }}
                    </p>
                </div>
                @endif
            </div>

            <!-- Associated Content Info -->
             @if($media->contenu)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Lié au contenu
                </h3>
                
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div>
                        <p class="font-bold text-gray-900">{{ $media->contenu->titre }}</p>
                        <p class="text-xs text-gray-500">ID: {{ $media->contenu->id }}</p>
                    </div>
                </div>
            </div>
            @endif
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
                            <p class="text-xs text-gray-400 uppercase tracking-wide">Ajouté le</p>
                            <p class="font-medium mt-1">{{ $media->created_at ? $media->created_at->format('d/m/Y à H:i') : 'N/A' }}</p>
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
                            <p class="font-medium mt-1">{{ $media->updated_at ? $media->updated_at->format('d/m/Y à H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50 rounded-2xl p-6 border border-red-100">
                <h3 class="text-red-800 font-bold mb-2">Zone de danger</h3>
                <p class="text-red-600 text-sm mb-4">Cette action est irréversible.</p>
                
                <form action="{{ route('admin.medias.destroy', $media->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce média ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border border-red-200 shadow-sm text-sm font-medium rounded-xl text-red-700 bg-white hover:bg-red-50 hover:border-red-300 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Supprimer le média
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
