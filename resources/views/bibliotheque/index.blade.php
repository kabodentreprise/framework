@extends('layouts.admin')

@section('title', 'Ma Bibliothèque')

@section('content')
<div class="px-6 py-6 border-b border-gray-100 flex justify-between items-center bg-white">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Ma Bibliothèque</h1>
        <p class="text-gray-500">Retrouvez tous vos contenus achetés ici.</p>
    </div>
    <a href="{{ route('catalogue.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
        Explorer le catalogue
    </a>
</div>

<div class="p-6">
    @if($achats->isEmpty())
        <div class="text-center py-12 bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4 text-gray-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Votre bibliothèque est vide</h3>
            <p class="mt-1 text-gray-500">Vous n'avez pas encore acheté de contenu.</p>
            <div class="mt-6">
                <a href="{{ route('catalogue.index') }}" class="text-blue-600 hover:text-blue-500 font-medium">
                    Découvrir des contenus intéressants <span aria-hidden="true">&rarr;</span>
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($achats as $achat)
                @php $contenu = $achat->contenu; @endphp
                @if($contenu)
                <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 overflow-hidden group">
                    <div class="h-48 bg-gray-200 relative">
                         @if($contenu->medias->where('type_media', 'image')->first())
                            <img src="{{ asset('storage/' . $contenu->medias->where('type_media', 'image')->first()->chemin_fichier) }}" alt="{{ $contenu->titre }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-100 to-indigo-50">
                                <svg class="w-12 h-12 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                        <div class="absolute top-2 right-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-sm">
                            ACQUIS
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-full">{{ $contenu->typeContenu->nom_contenu ?? 'Contenu' }}</span>
                            <span class="text-xs text-gray-400">{{ $achat->created_at->format('d M Y') }}</span>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-1 group-hover:text-blue-600 transition truncate">{{ $contenu->titre }}</h3>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ Str::limit(strip_tags($contenu->texte), 100) }}</p>
                        
                        <div class="flex items-center justify-between mt-auto">
                            <div class="flex items-center">
                                <div class="w-6 h-6 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center text-xs font-bold mr-2">
                                     {{ strtoupper(substr($contenu->auteur->prenom ?? 'A', 0, 1)) }}
                                </div>
                                <span class="text-xs text-gray-600">{{ $contenu->auteur->prenom ?? 'Auteur' }}</span>
                            </div>
                            <a href="{{ route('catalogue.show', $contenu->slug) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lire &rarr;</a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>

        </div>

        <div class="mt-6">
             {{-- Pagination logic should be adjusted if we have strict arrays instead of paginator, but for now assuming get() --}}
        </div>
    @endif

    <!-- SECTION FAVORIS -->
    <div class="mt-12 pt-12 border-t border-gray-200">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" /></svg>
            Mes Favoris
        </h2>

        @if($favoris->isEmpty())
            <div class="text-center py-8 bg-gray-50 rounded-xl border border-gray-100 border-dashed">
                <p class="text-gray-500">Vous n'avez aucun contenu en favoris.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($favoris as $contenu)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 overflow-hidden group">
                        <div class="h-48 bg-gray-200 relative">
                             @if($contenu->medias->where('type_media', 'image')->first())
                                <img src="{{ asset('storage/' . $contenu->medias->where('type_media', 'image')->first()->chemin_fichier) }}" alt="{{ $contenu->titre }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-pink-100 to-red-50">
                                    <svg class="w-12 h-12 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-medium text-pink-600 bg-pink-50 px-2 py-1 rounded-full">{{ $contenu->typeContenu->nom_contenu ?? 'Contenu' }}</span>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1 group-hover:text-pink-600 transition truncate">{{ $contenu->titre }}</h3>
                            <a href="{{ route('catalogue.show', $contenu->slug) }}" class="text-pink-600 hover:text-pink-800 text-sm font-medium mt-2 inline-block">Voir &rarr;</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
