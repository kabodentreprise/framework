@extends('layouts.admin')

@section('title', 'Détails du Type de Média')
@section('page-title', 'Détails du Type de Média')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="h-16 w-16 rounded-2xl bg-orange-600 flex items-center justify-center shadow-lg shadow-orange-600/20 text-white text-2xl font-bold tracking-wider uppercase border-4 border-white ring-1 ring-gray-100">
                {{ substr($typeMedia->nom_media, 0, 2) }}
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $typeMedia->nom_media }}</h1>
                <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        ID: <span class="font-mono text-gray-700 font-semibold">#{{ $typeMedia->id }}</span>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.type-medias.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 font-medium hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                Retour
            </a>
            <a href="{{ route('admin.type-medias.edit', $typeMedia->id) }}" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl font-medium shadow-md shadow-orange-500/20 hover:from-orange-600 hover:to-orange-700 transition-all flex items-center gap-2">
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
            <!-- Details Card -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informations
                </h3>
                <div class="prose prose-orange max-w-none">
                   <p class="text-gray-600">
                       Le type de média <span class="font-bold text-gray-900">{{ $typeMedia->nom_media }}</span> est utilisé pour catégoriser les fichiers médias de la plateforme.
                   </p>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center group hover:shadow-md transition-all duration-300">
                    <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <p class="text-sm font-medium text-gray-500">Médias associés</p>
                    <p class="text-xl font-bold text-gray-900">{{ $typeMedia->medias->count() }}</p>
                </div>
            </div>

            <!-- Content List (Optional) -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Médias associés
                </h3>
                
                @if($typeMedia->medias && $typeMedia->medias->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom du fichier</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($typeMedia->medias->take(5) as $media)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $media->url_media }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $media->created_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 italic p-4 text-center">Aucun média associé à ce type pour le moment.</p>
                @endif
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
                            <p class="font-medium mt-1">{{ $typeMedia->created_at ? $typeMedia->created_at->format('d/m/Y') : 'N/A' }}</p>
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
                            <p class="font-medium mt-1">{{ $typeMedia->updated_at ? $typeMedia->updated_at->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50 rounded-2xl p-6 border border-red-100">
                <h3 class="text-red-800 font-bold mb-2">Zone de danger</h3>
                <p class="text-red-600 text-sm mb-4">Cette action est irréversible.</p>
                
                <form action="{{ route('admin.type-medias.destroy', $typeMedia->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type de média ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border border-red-200 shadow-sm text-sm font-medium rounded-xl text-red-700 bg-white hover:bg-red-50 hover:border-red-300 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Supprimer le type
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
