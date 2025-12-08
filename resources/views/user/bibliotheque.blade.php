@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Ma Bibliothèque</h1>
                <p class="mt-1 text-gray-500">Retrouvez tous vos contenus achetés et débloqués.</p>
            </div>
            <a href="{{ route('catalogue.index') }}" class="text-orange-600 hover:text-orange-700 font-medium">
                + Explorer le catalogue
            </a>
        </div>

        @if($achats->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Votre bibliothèque est vide</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Vous n'avez pas encore acheté de contenu premium. Explorez notre catalogue pour découvrir des trésors culturels.</p>
                <a href="{{ route('catalogue.index') }}" class="inline-flex items-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-lg shadow transition">
                    Découvrir les contenus
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($achats as $achat)
                    @php $contenu = $achat->contenu; @endphp
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col group">
                        {{-- Cover --}}
                        <div class="h-40 bg-gray-200 relative overflow-hidden">
                             @if($contenu->medias->isNotEmpty() && $contenu->medias->first()->type == 'image/jpeg') 
                                <img src="{{ $contenu->medias->first()->chemin }}" alt="{{ $contenu->titre }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                             @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                                    <span class="text-4xl">📚</span>
                                </div>
                             @endif
                             
                             <div class="absolute inset-0 bg-black/20 group-hover:bg-black/10 transition-colors"></div>
                             
                             <div class="absolute bottom-3 right-3 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-bold shadow flex items-center">
                                 <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                 Acquis
                             </div>
                        </div>

                        <div class="p-5 flex-1 flex flex-col">
                            <div class="text-xs text-gray-500 mb-2">Acheté le {{ $achat->created_at->format('d/m/Y') }}</div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">{{ $contenu->titre }}</h3>
                            <p class="text-sm text-gray-600 line-clamp-2 mb-4">{{ $contenu->description ?? 'Pas de description' }}</p>
                            
                            <div class="mt-auto pt-4 border-t border-gray-50">
                                <a href="{{ route('catalogue.show', $contenu->slug) }}" class="block w-full py-2 bg-gray-900 hover:bg-gray-800 text-white text-center rounded-lg font-medium transition text-sm">
                                    Consulter maintenant
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $achats->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
