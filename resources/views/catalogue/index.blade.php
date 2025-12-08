@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f8f5f2]"> {{-- Fond blanc cassé / parchemin --}}
    
    {{-- Hero Section Culturel --}}
    <div class="relative bg-gradient-to-r from-green-900 to-green-800 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24 relative z-10">
            <div class="text-center">
                <span class="inline-block py-1 px-3 rounded-full bg-yellow-500/20 border border-yellow-500/30 text-yellow-300 text-sm font-semibold tracking-wider mb-4 uppercase">
                    Patrimoine & Tradition
                </span>
                <h1 class="text-4xl md:text-6xl font-serif font-bold text-white mb-6 leading-tight">
                    Trésors Culturels du Bénin
                </h1>
                <p class="text-lg md:text-xl text-green-100 max-w-2xl mx-auto font-light">
                    Explorez notre collection unique d'œuvres, d'histoires et de savoirs ancestraux. 
                    Une immersion au cœur de l'identité béninoise.
                </p>
            </div>
        </div>

        {{-- Bandeau drapeau subtil en bas --}}
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-green-600 via-yellow-500 to-red-600"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20">
        
        <!-- Barre de Filtres Flottante -->
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 mb-12 border border-gray-100">
            <form action="{{ route('catalogue.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
                
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <div class="p-2 bg-orange-100 rounded-lg text-orange-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </div>
                    <select name="type" class="w-full md:w-48 rounded-lg border-gray-200 focus:border-green-600 focus:ring-green-600 text-gray-700 font-medium bg-gray-50 hover:bg-white transition-colors cursor-pointer" onchange="this.form.submit()">
                        <option value="">Tous les Arts</option>
                        @foreach($types as $type)
                            <option value="{{ $type->nom_contenu }}" {{ request('type') == $type->nom_contenu ? 'selected' : '' }}>
                                {{ $type->nom_contenu }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-96 relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher une œuvre, un artiste..." 
                           class="w-full rounded-lg border-gray-200 focus:border-green-600 focus:ring-green-600 pl-11 py-2.5 text-gray-800 placeholder-gray-400 bg-gray-50 focus:bg-white transition-all">
                    <span class="absolute left-3 top-3 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                </div>
            </form>
        </div>

        <!-- Grille de Contenus -->
        @if($contenus->isEmpty())
            <div class="text-center py-24">
                <div class="inline-block p-6 rounded-full bg-gray-100 mb-6">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <h3 class="text-xl font-serif text-gray-800 mb-2">Aucun trésor trouvé</h3>
                <p class="text-gray-500">Essayez de modifier vos critères de recherche.</p>
                <a href="{{ route('catalogue.index') }}" class="mt-6 inline-flex items-center text-green-700 hover:text-green-800 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Réinitialiser le catalogue
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 pb-16">
                @foreach($contenus as $contenu)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden border border-gray-100 transform hover:-translate-y-1">
                    
                    {{-- Cover Image --}}
                    <div class="h-56 relative overflow-hidden bg-gray-200">
                        @if($contenu->medias->isNotEmpty() && $contenu->medias->first()->type == 'image/jpeg')
                            <img src="{{ $contenu->medias->first()->chemin }}" alt="{{ $contenu->titre }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            {{-- Pattern de remplacement --}}
                            <div class="w-full h-full flex items-center justify-center bg-[#eae5dd]" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23d6d0c4\' fill-opacity=\'0.8\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E');">
                                <span class="text-4xl filter grayscale opacity-50">🖼️</span>
                            </div>
                        @endif
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        {{-- Badges --}}
                        <div class="absolute top-4 left-4 flex gap-2">
                             <span class="bg-white/95 backdrop-blur-md text-gray-800 text-xs px-3 py-1.5 rounded-full font-serif font-bold shadow-sm border border-gray-100 uppercase tracking-widest">
                                {{ $contenu->typeContenu->nom_contenu ?? 'Art' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 flex-1 flex flex-col relative">
                        {{-- Prix / Gratuit Badge Flottant --}}
                        <div class="absolute -top-5 right-6">
                            <span class="{{ $contenu->estGratuit() ? 'bg-green-600 text-green-50' : 'bg-[#d97706] text-white' }} px-4 py-2 rounded-lg font-bold shadow-md text-sm flex items-center">
                                @if(!$contenu->estGratuit()) <span class="mr-1 text-xs opacity-80">CFA</span> @endif
                                {{ $contenu->estGratuit() ? 'GRATUIT' : number_format($contenu->prix, 0, ',', ' ') }}
                            </span>
                        </div>

                        <div class="mt-4 flex items-center text-xs text-gray-500 mb-3 font-medium">
                            <span class="flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                {{ $contenu->auteur->prenom }} {{ $contenu->auteur->nom }}
                            </span>
                            <span class="mx-2 text-gray-300">•</span>
                            <span>{{ $contenu->created_at->format('M Y') }}</span>
                        </div>

                        <h3 class="text-xl font-serif font-bold text-gray-900 mb-3 leading-snug group-hover:text-green-800 transition-colors">
                            <a href="{{ route('catalogue.show', $contenu->slug) }}">
                                {{ $contenu->titre }}
                            </a>
                        </h3>

                        <p class="text-gray-600 text-sm mb-6 line-clamp-3 leading-relaxed">
                            {{ Str::limit(strip_tags($contenu->description ?? $contenu->texte), 110) }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-gray-100 flex justify-between items-center group/btn">
                            @if($contenu->estGratuit())
                                <a href="{{ route('catalogue.show', $contenu->slug) }}" class="text-gray-400 group-hover/btn:text-orange-600 font-medium text-sm flex items-center transition-colors">
                                    Explorer l'œuvre
                                    <svg class="w-4 h-4 ml-2 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                                <span class="text-green-600 bg-green-50 px-2 py-1 rounded text-xs font-bold">Gratuit</span>
                            @else
                                {{-- Contenu Payant --}}
                                @auth
                                    <button 
                                        onclick="initierPaiement('{{ $contenu->id }}', '{{ $contenu->titre }}', '{{ intval($contenu->prix) }}')"
                                        class="w-full py-2 px-4 bg-orange-600 hover:bg-orange-700 text-white font-bold rounded-lg shadow-md transition text-sm flex items-center justify-center cursor-pointer">
                                        Payer {{ number_format($contenu->prix, 0, ',', ' ') }} FCFA
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="w-full py-2 px-4 bg-gray-800 hover:bg-gray-900 text-white font-bold rounded-lg shadow-md transition text-sm flex items-center justify-center text-center">
                                        Se connecter pour acheter
                                    </a>
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="pb-12">
                {{ $contenus->links() }}
            </div>
        @endif
    </div>

    {{-- Formulaire caché pour soumission après succès (si géré par JS) ou par le widget --}}
    <form id="payment-form" action="{{ route('paiement.callback') }}" method="POST" style="display:none;">
        @csrf
        <input type="hidden" name="id_contenu" id="payment-id-contenu">
        <input type="hidden" name="id" id="payment-transaction-id"> {{-- Stockera l'ID de transaction si nécessaire --}}
    </form>

    {{-- Script FedaPay Global --}}
    <script src="https://checkout.fedapay.com/js/checkout.js"></script>
    <script>
        function initierPaiement(id, titre, prix) {
            let form = document.getElementById('payment-form');
            document.getElementById('payment-id-contenu').value = id;

            try {
                let widget = FedaPay.init({
                    public_key: '{{ config('fedapay.public_key') }}',
                    transaction: {
                        amount: prix,
                        description: 'Achat : ' + titre
                    },
                    customer: {
                        email: '{{ Auth::user()->email ?? "" }}',
                        lastname: '{{ Auth::user()->nom ?? "" }}',
                        firstname: '{{ Auth::user()->prenom ?? "" }}'
                    },
                    currency: {
                        iso: 'XOF'
                    }
                });
                
                // Configurer le bouton pour lancer le widget
                widget.open();
                
            } catch (e) {
                console.error("Erreur FedaPay:", e);
                alert("Impossible d'initialiser le paiement. Veuillez réessayer.");
            }
        }
    </script>


    {{-- Footer Ornemental --}}
    <div class="bg-gray-800 text-gray-500 py-12 border-t-4 border-yellow-500">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <div class="flex justify-center space-x-4 mb-4 opacity-50">
                 <svg class="w-8 h-8" viewBox="0 0 100 100" fill="currentColor"><circle cx="50" cy="50" r="40"/></svg>
                 <svg class="w-8 h-8" viewBox="0 0 100 100" fill="currentColor"><rect x="10" y="10" width="80" height="80"/></svg>
                 <svg class="w-8 h-8" viewBox="0 0 100 100" fill="currentColor"><polygon points="50,10 90,90 10,90"/></svg>
            </div>
            <p class="font-serif italic">"La culture est ce qui reste quand on a tout oublié."</p>
        </div>
    </div>
</div>
@endsection

