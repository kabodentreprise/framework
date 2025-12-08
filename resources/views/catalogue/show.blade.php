@extends('layouts.app')

@section('content')
<div class="py-12 bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Fil d'ariane -->
        <nav class="flex mb-8 text-sm text-gray-500">
            <a href="/" class="hover:text-orange-600">Accueil</a>
            <span class="mx-2">/</span>
            <a href="{{ route('catalogue.index') }}" class="hover:text-orange-600">Catalogue</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">{{ $contenu->titre }}</span>
        </nav>

        <!-- En-tête Contenu -->
        <div class="mb-8">
            <span class="inline-block px-3 py-1 rounded-full bg-orange-100 text-orange-800 text-xs font-bold uppercase tracking-wide mb-4">
                {{ $contenu->typeContenu->nom_contenu ?? 'Article' }}
            </span>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 leading-tight">{{ $contenu->titre }}</h1>
            
            <div class="flex items-center text-gray-600 text-sm border-b border-gray-200 pb-8">
                <div class="flex items-center mr-6">
                    <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-2 text-xs font-bold text-gray-600">
                        {{ substr($contenu->auteur->prenom, 0, 1) }}{{ substr($contenu->auteur->nom, 0, 1) }}
                    </div>
                    <span>{{ $contenu->auteur->prenom }} {{ $contenu->auteur->nom }}</span>
                </div>
                <div>Publié le {{ $contenu->created_at->format('d M Y') }}</div>
                
                @if($contenu->region)
                    <div class="ml-6 flex items-center">
                        <span class="mr-1">📍</span> {{ $contenu->region->nom_region }}
                    </div>
                @endif
            </div>
        </div>

        <!-- ZONE DE CONTENU -->
        
        {{-- Message Flash --}}
        @if(session('info'))
            <div class="mb-6 p-4 bg-blue-50 text-blue-800 rounded-lg flex items-center">
                <span class="mr-2">ℹ️</span> {{ session('info') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 text-red-800 rounded-lg flex items-center">
                <span class="mr-2">⚠️</span> {{ session('error') }}
            </div>
        @endif


        @if($accesAutorise)
            <!-- ACCÈS AUTORISÉ : Affichage Complet -->
            <div class="prose prose-lg max-w-none text-gray-800">
                {{-- Media Player (Exemple simplifié) --}}
                @if($contenu->medias->isNotEmpty())
                    <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
                        @php $media = $contenu->medias->first(); @endphp
                        
                        @if ($media->type_media === 'Video' || str_contains($media->type, 'video') || str_contains($media->description, 'Vidéo'))
                             {{-- Vidéo Placeholder --}}
                             <div class="aspect-w-16 aspect-h-9 bg-black flex items-center justify-center text-white h-96">
                                 <div class="text-center">
                                     <svg class="w-20 h-20 mx-auto opacity-80" fill="currentColor" viewBox="0 0 20 20"><path d="M6 4l10 6-10 6V4z"/></svg>
                                     <p class="mt-4">Lecteur Vidéo (Simulation)</p>
                                 </div>
                             </div>
                        @else
                             {{-- Image --}}
                             <img src="{{ $media->chemin }}" alt="{{ $contenu->titre }}" class="w-full h-auto">
                        @endif
                    </div>
                @endif

                {{-- Texte Complet --}}
                <div class="content-body">
                    {!! nl2br(e($contenu->texte)) !!}
                </div>
            </div>

            <div class="mt-12 p-6 bg-green-50 rounded-xl border border-green-100 text-center">
                <p class="text-green-800 font-medium mb-4">Vous avez accès à ce contenu.</p>
                @if(!$contenu->estGratuit())
                    <a href="{{ route('bibliotheque.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                        Voir dans ma bibliothèque
                    </a>
                @endif
            </div>

        @else
            <!-- ACCÈS RESTREINT : Paywall -->
            <div class="relative">
                {{-- Extrait avec flou --}}
                <div class="prose prose-lg max-w-none text-gray-800 mb-8 filter blur-[1px] select-none opacity-50 relative h-64 overflow-hidden">
                     {!! nl2br(e(Str::limit($contenu->texte, 500))) !!}
                     <div class="absolute inset-0 bg-gradient-to-b from-transparent to-white"></div>
                </div>

                {{-- Carte de Paiement --}}
                <div class="absolute top-10 left-0 right-0 max-w-md mx-auto bg-white rounded-2xl shadow-xl border border-orange-100 overflow-hidden z-20 transform hover:-translate-y-1 transition duration-300">
                    <div class="bg-orange-600 p-6 text-center text-white">
                        <h3 class="text-xl font-bold mb-1">Contenu Premium</h3>
                        <p class="opacity-90">Débloquez l'accès complet maintenant</p>
                    </div>
                    <div class="p-8 text-center">
                        <div class="text-5xl font-extrabold text-gray-900 mb-2">
                            {{ number_format($contenu->prix, 0, ',', ' ') }} <span class="text-lg text-gray-500 font-normal">FCFA</span>
                        </div>
                        <p class="text-gray-500 mb-8">Paiement unique • Accès à vie</p>

                        <form action="{{ route('paiement.callback') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_contenu" value="{{ $contenu->id }}">
                            
                            @auth
                                <!-- FedaPay Checkout Script -->
                                <script
                                    src="https://checkout.fedapay.com/js/checkout.js"
                                    data-public-key="{{ config('fedapay.public_key') }}"
                                    data-button-text="Payer {{ number_format($contenu->prix, 0, ',', ' ') }} FCFA"
                                    data-transaction-amount="{{ $contenu->prix }}"
                                    data-transaction-description="Achat : {{ $contenu->titre }}"
                                    data-currency-iso="XOF"
                                    data-customer-email="{{ Auth::user()->email ?? '' }}"
                                    data-customer-firstname="{{ Auth::user()->prenom ?? '' }}"
                                    data-customer-lastname="{{ Auth::user()->nom ?? '' }}">
                                </script>
                                <p class="mt-4 text-xs text-gray-400">Paiement sécurisé par FedaPay. (Ref: {{ $contenu->id }})</p>
                                <!-- Debug: Key Present: {{ config('fedapay.public_key') ? 'YES' : 'NO' }} -->
                            @else
                                <div class="mt-4 p-3 bg-yellow-50 text-yellow-800 text-sm rounded">
                                    Veuillez vous connecter pour finaliser l'achat.
                                </div>
                                <a href="{{ route('login') }}" class="block mt-4 w-full py-3 px-6 bg-gray-800 hover:bg-gray-900 text-white font-bold rounded-xl shadow-md transition text-center">
                                    Se connecter
                                </a>
                            @endauth
                        </form>
                    </div>
                </div>
            </div>
            <!-- Fin Paywall -->
            
            <div class="mt-64 text-center">
                 <p class="text-gray-500 italic">Ce contenu est protégé par les droits d'auteur.</p>
            </div>
        @endif

    </div>
</div>
@endsection
