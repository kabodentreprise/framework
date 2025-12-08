@extends('layouts.admin')

@section('title', 'Détails du Paiement')
@section('page-title', 'Détails du Paiement')

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="px-3 py-1 text-xs font-bold rounded-full uppercase tracking-wide 
                    @if($achat->statut == 'payé') bg-green-100 text-green-700
                    @elseif($achat->statut == 'en_attente') bg-yellow-100 text-yellow-700
                    @elseif($achat->statut == 'échoué') bg-red-100 text-red-700
                    @else bg-gray-100 text-gray-700 @endif">
                    {{ ucfirst($achat->statut) }}
                </span>
                <span class="text-sm text-gray-500 flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $achat->date_achat ? $achat->date_achat->format('d/m/Y H:i') : 'Date inconnue' }}
                </span>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Paiement #{{ $achat->id }}</h1>
            <p class="text-gray-500 mt-1">Référence: <span class="font-mono font-medium text-gray-700">{{ $achat->reference }}</span></p>
        </div>
        
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.paiements.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 font-medium hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Informations Financières -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Détails Financiers
            </h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-50">
                    <span class="text-gray-600">Montant Total</span>
                    <span class="text-xl font-bold text-gray-900">{{ number_format($achat->montant, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-gray-500 text-sm">Part Auteur</span>
                    <span class="font-medium text-gray-900">{{ number_format($achat->montant_auteur, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                    <span class="text-gray-500 text-sm">Commission Plateforme</span>
                    <span class="font-medium text-gray-900">{{ number_format($achat->montant_plateforme, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-500 text-sm">Transaction FedaPay ID</span>
                    <span class="font-mono text-sm text-gray-900">{{ $achat->feda_transaction_id ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Informations Utilisateur et Contenu -->
        <div class="space-y-6">
            <!-- Utilisateur -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Acheteur
                </h3>
                @if($achat->utilisateur)
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-lg">
                            {{ substr($achat->utilisateur->prenom, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-bold text-gray-900">{{ $achat->utilisateur->getFullName() }}</p>
                            <p class="text-sm text-gray-500">{{ $achat->utilisateur->email }}</p>
                            <p class="text-xs text-gray-400">ID: {{ $achat->utilisateur->id }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-red-500 italic">Utilisateur supprimé ou introuvable.</p>
                @endif
            </div>

            <!-- Contenu -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    Contenu Acheté
                </h3>
                @if($achat->contenu)
                    <div>
                        <a href="{{ route('admin.contenus.show', $achat->contenu->id) }}" class="font-bold text-lg text-orange-600 hover:text-orange-700 hover:underline">
                            {{ $achat->contenu->titre }}
                        </a>
                        <div class="mt-2 flex gap-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded bg-gray-100 text-gray-600">{{ $achat->contenu->typeContenu->nom_contenu ?? 'Type inconnu' }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-red-500 italic">Contenu supprimé ou introuvable.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
