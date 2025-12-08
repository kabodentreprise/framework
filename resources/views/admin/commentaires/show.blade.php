@extends('layouts.admin')

@section('title', 'Détails du Commentaire')
@section('page-title', 'Détails du Commentaire')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <div class="flex justify-between items-start mb-6">
            <h2 class="text-xl font-bold text-gray-800">Détails du Commentaire #{{ $commentaire->id }}</h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.commentaires.edit', $commentaire->id) }}" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:outline-none focus:border-orange-900 focus:ring ring-orange-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Modifier
                </a>
                <a href="{{ route('admin.commentaires.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Retour
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Auteur</h3>
                <p class="text-lg font-semibold text-gray-900">
                    {{ $commentaire->utilisateur ? $commentaire->utilisateur->getFullName() : 'Utilisateur supprimé' }}
                </p>
                <p class="text-sm text-gray-500">{{ $commentaire->utilisateur ? $commentaire->utilisateur->email : '' }}</p>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Contenu Lié</h3>
                <p class="text-lg font-semibold text-gray-900">
                    {{ $commentaire->contenu ? $commentaire->contenu->titre : 'Contenu supprimé' }}
                </p>
                <p class="text-sm text-gray-500">
                    @if($commentaire->contenu && $commentaire->contenu->typeContenu)
                        Type: {{ $commentaire->contenu->typeContenu->nom_contenu }}
                    @endif
                </p>
            </div>
        </div>

        <div class="mb-6">
            <div class="flex items-center gap-4 mb-2">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Note</h3>
                @if($commentaire->note)
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= $commentaire->note ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        @endfor
                        <span class="ml-2 text-gray-600 font-medium">({{ $commentaire->note }}/5)</span>
                    </div>
                @else
                    <span class="text-gray-400 italic">Aucune note</span>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Date</h3>
                <p class="text-gray-900 font-medium">{{ \Carbon\Carbon::parse($commentaire->date)->format('d/m/Y') }}</p>
            </div>
        </div>

        <div class="border-t border-gray-100 pt-6">
            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Commentaire</h3>
            <div class="bg-gray-50 rounded-xl p-6 text-gray-800 leading-relaxed whitespace-pre-wrap">
                {{ $commentaire->texte }}
            </div>
        </div>
        
    </div>
</div>
@endsection
