@extends('layouts.admin')

@section('title', 'Détails Utilisateur')
@section('page-title', 'Détails Utilisateur')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-orange-700 h-32"></div>
            <div class="px-6 relative">
                <div class="h-24 w-24 rounded-full border-4 border-white shadow-md absolute -top-12 bg-white flex items-center justify-center overflow-hidden">
                    @if($utilisateur->photo)
                        <img src="{{ asset('storage/' . $utilisateur->photo) }}" alt="{{ $utilisateur->prenom }}" class="h-full w-full object-cover">
                    @else
                        <span class="text-3xl font-bold text-gray-500">{{ substr($utilisateur->prenom, 0, 1) }}{{ substr($utilisateur->nom, 0, 1) }}</span>
                    @endif
                </div>
            </div>
            <div class="px-6 pt-16 pb-8">
                <h2 class="text-xl font-bold text-gray-900">{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</h2>
                <div class="flex items-center mt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $utilisateur->role->nom_role ?? 'Sans rôle' }}
                    </span>
                    <span class="mx-2 text-gray-300">|</span>
                    <span class="text-sm text-gray-500">{{ $utilisateur->email }}</span>
                </div>

                <div class="mt-8 border-t border-gray-100 pt-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Statut</span>
                        @php
                            $statusClasses = match($utilisateur->statut) {
                                'actif' => 'bg-green-100 text-green-800',
                                'suspendu' => 'bg-red-100 text-red-800', 
                                'restreint' => 'bg-yellow-100 text-yellow-800',
                                default => 'bg-gray-100 text-gray-800'
                            };
                        @endphp
                        <span class="px-2 py-0.5 rounded-full {{ $statusClasses }} font-medium capitalize">{{ $utilisateur->statut }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Inscrit le</span>
                        <span class="text-gray-900 font-medium">{{ $utilisateur->date_inscription->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Dernière connexion</span>
                        <span class="text-gray-900 font-medium">{{ $utilisateur->last_login_at ? $utilisateur->last_login_at->diffForHumans() : 'Jamais' }}</span>
                    </div>
                </div>

                <div class="mt-8 grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.utilisateurs.edit', $utilisateur) }}" class="flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 hover:text-orange-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                        Modifier
                    </a>
                    <form action="{{ route('admin.utilisateurs.destroy', $utilisateur) }}" method="POST" onsubmit="return confirm('Attention ! Cette action est irréversible. Êtes-vous sûr ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-red-600 bg-red-50 hover:bg-red-100 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Details & Stats -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Informations Detail -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b border-gray-100 pb-4">Informations Personnelles</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Nom Complet</label>
                    <p class="mt-1 text-base text-gray-900 font-medium">{{ $utilisateur->prenom }} {{ $utilisateur->nom }}</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Email</label>
                    <p class="mt-1 text-base text-gray-900 font-medium">{{ $utilisateur->email }}</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Sexe</label>
                    <p class="mt-1 text-base text-gray-900 font-medium">{{ $utilisateur->sexe_formate }}</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Date de Naissance</label>
                    <p class="mt-1 text-base text-gray-900 font-medium">
                        {{ $utilisateur->date_naissance ? $utilisateur->date_naissance->format('d/m/Y') : 'Non renseignée' }} 
                        <span class="text-gray-400 text-xs ml-1">({{ $utilisateur->age }} ans)</span>
                    </p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Langue Préférée</label>
                    <p class="mt-1 text-base text-gray-900 font-medium flex items-center">
                        <span class="h-2 w-2 rounded-full bg-indigo-400 mr-2"></span>
                        {{ $utilisateur->langue->nom_langue ?? 'Non définie' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Activity/Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center hover:shadow-md transition-shadow">
                <div class="p-3 bg-indigo-50 rounded-full mb-3">
                    <svg class="w-8 h-8 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Contributions</h3>
                <div class="text-3xl font-bold text-indigo-600 my-1">{{ $utilisateur->contenus->count() }}</div>
                <p class="text-sm text-gray-500">Articles publiés</p>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center hover:shadow-md transition-shadow">
                <div class="p-3 bg-pink-50 rounded-full mb-3">
                    <svg class="w-8 h-8 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">Commentaires</h3>
                <div class="text-3xl font-bold text-pink-600 my-1">{{ $utilisateur->commentaires->count() }}</div>
                <p class="text-sm text-gray-500">Interactions</p>
            </div>
        </div>
        
        <div class="flex justify-end">
            <a href="{{ route('admin.utilisateurs.index') }}" class="text-gray-500 hover:text-orange-600 font-medium text-sm flex items-center transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Retour à la liste
            </a>
        </div>
    </div>
</div>
@endsection
