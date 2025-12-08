@extends('layouts.admin')

@section('title', 'Détails du Contenu')
@section('page-title', 'Détails du Contenu')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide 
                    @if($contenu->statut == 'publié') bg-green-100 text-green-700
                    @elseif($contenu->statut == 'en_attente') bg-yellow-100 text-yellow-700
                    @elseif($contenu->statut == 'rejeté') bg-red-100 text-red-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ ucfirst(str_replace('_', ' ', $contenu->statut)) }}
                </span>
                <span class="text-sm text-gray-500 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $contenu->created_at->format('d/m/Y') }}
                </span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ $contenu->titre }}</h1>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.contenus.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 font-medium hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                Retour
            </a>
            <a href="{{ route('admin.contenus.edit', $contenu->id) }}" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl font-medium shadow-md shadow-orange-500/20 hover:from-orange-600 hover:to-orange-700 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content (2/3) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Content Body -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <div class="prose prose-orange max-w-none">
                    {!! nl2br(e($contenu->texte)) !!}
                </div>
            </div>

            <!-- Associated Medias (Optional) -->
            @if(isset($contenu->medias) && $contenu->medias->count() > 0)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Médias associés ({{ $contenu->medias->count() }})</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($contenu->medias as $media)
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden relative group">
                            @php
                                $extension = pathinfo($media->chemin, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp
                            
                            @if($isImage)
                                <img src="{{ asset('storage/' . $media->chemin) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold uppercase">
                                    {{ $extension }}
                                </div>
                            @endif
                            <a href="{{ route('admin.medias.show', $media->id) }}" class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar (1/3) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Properties Card -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-6">Attributs</h3>
                
                <div class="space-y-4">
                    <!-- Type -->
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500 text-sm">Type</span>
                        <span class="font-medium text-gray-900">{{ $contenu->typeContenu->nom_contenu ?? 'N/A' }}</span>
                    </div>

                    <!-- Region -->
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500 text-sm">Région</span>
                        <span class="font-medium text-gray-900">{{ $contenu->region->nom_region ?? 'N/A' }}</span>
                    </div>

                    <!-- Langue -->
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500 text-sm">Langue</span>
                        <span class="font-medium text-gray-900">{{ $contenu->langue->nom_langue ?? 'N/A' }}</span>
                    </div>

                    <!-- Auteur -->
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-500 text-sm">Auteur</span>
                        <div class="flex items-center gap-2">
                            <div class="h-6 w-6 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-bold">
                                {{ substr($contenu->auteur->prenom ?? 'A', 0, 1) }}
                            </div>
                            <span class="font-medium text-gray-900">{{ $contenu->auteur->getFullName() ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>

                     </div>
                 </div>
            </div>

            <!-- Accès et Prix -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-widest mb-6">Sécurité / Accès</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500 text-sm">Type d'accès</span>
                        @if($contenu->estGratuit())
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-green-100 text-green-700">Gratuit</span>
                        @else
                            <span class="px-2 py-1 text-xs font-bold rounded-full bg-blue-100 text-blue-700">Payant</span>
                        @endif
                    </div>
                    @if($contenu->estPayant())
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500 text-sm">Prix</span>
                        <span class="font-bold text-gray-900">{{ number_format($contenu->prix, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-500 text-sm">Part auteur ({{$contenu->pourcentage_auteur}}%)</span>
                        <span class="text-sm text-gray-900">{{ number_format($contenu->calculerMontantAuteur(), 0, ',', ' ') }} FCFA</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Actions Modération (Si non publié) -->
            @if($contenu->statut !== 'publié')
            <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100">
                <h3 class="text-indigo-800 font-bold mb-4">Modération</h3>
                <div class="flex gap-2">
                    <form action="{{ route('admin.contenus.changer-statut', $contenu->id) }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="statut" value="publié">
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold shadow-sm transition-colors text-sm">
                            Valider
                        </button>
                    </form>
                    <form action="{{ route('admin.contenus.changer-statut', $contenu->id) }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="statut" value="rejeté">
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold shadow-sm transition-colors text-sm">
                            Rejeter
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Meta Info Card -->
            <div class="bg-gray-900 rounded-2xl p-6 shadow-lg text-white">
                 <h3 class="text-sm font-bold uppercase tracking-widest mb-6 text-gray-400">Métadonnées</h3>
                 <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-400">Slug</p>
                        <p class="font-mono text-sm break-all">{{ $contenu->slug }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Date de validation</p>
                        <p class="font-medium">{{ $contenu->date_validation ? $contenu->date_validation->format('d/m/Y H:i') : 'Non validé' }}</p>
                    </div>
                 </div>
            </div>

            <!-- Danger Zone -->
            <div class="bg-red-50 rounded-2xl p-6 border border-red-100">
                <h3 class="text-red-800 font-bold mb-2">Zone de danger</h3>
                <p class="text-red-600 text-sm mb-4">Cette action est irréversible.</p>
                
                <form action="{{ route('admin.contenus.destroy', $contenu->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce contenu ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-3 border border-red-200 shadow-sm text-sm font-medium rounded-xl text-red-700 bg-white hover:bg-red-50 hover:border-red-300 transition-all">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Supprimer le contenu
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
