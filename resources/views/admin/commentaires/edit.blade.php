@extends('layouts.admin')

@section('title', 'Modifier le Commentaire')
@section('page-title', 'Modifier le Commentaire')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Modifier le Commentaire</h2>
                <p class="text-sm text-gray-500 mt-1">ID: {{ $commentaire->id }}</p>
            </div>
            <a href="{{ route('admin.commentaires.index') }}" class="p-2 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        <form action="{{ route('admin.commentaires.update', $commentaire->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Utilisateur -->
                <div>
                    <label for="id_utilisateur" class="block text-sm font-semibold text-gray-700 mb-2">Auteur <span class="text-red-500">*</span></label>
                    <select name="id_utilisateur" id="id_utilisateur" class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors" required>
                        <option value="">Sélectionner un utilisateur...</option>
                        @foreach($utilisateurs as $user)
                            <option value="{{ $user->id }}" {{ (old('id_utilisateur') ?? $commentaire->id_utilisateur) == $user->id ? 'selected' : '' }}>
                                {{ $user->getFullName() }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Contenu -->
                <div>
                    <label for="id_contenu" class="block text-sm font-semibold text-gray-700 mb-2">Contenu lié <span class="text-red-500">*</span></label>
                    <select name="id_contenu" id="id_contenu" class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors" required>
                        <option value="">Sélectionner un contenu...</option>
                        @foreach($contenus as $contenu)
                            <option value="{{ $contenu->id }}" {{ (old('id_contenu') ?? $commentaire->id_contenu) == $contenu->id ? 'selected' : '' }}>
                                {{ $contenu->titre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Note -->
                <div>
                    <label for="note" class="block text-sm font-semibold text-gray-700 mb-2">Note (optionnel)</label>
                    <input type="number" name="note" id="note" min="0" max="5" class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors" value="{{ old('note') ?? $commentaire->note }}" placeholder="0 à 5">
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-semibold text-gray-700 mb-2">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="date" id="date" class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors" value="{{ old('date') ?? $commentaire->date }}" required>
                </div>

                <!-- Texte -->
                <div>
                    <label for="texte" class="block text-sm font-semibold text-gray-700 mb-2">Commentaire <span class="text-red-500">*</span></label>
                    <textarea name="texte" id="texte" rows="5" class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors" required>{{ old('texte') ?? $commentaire->texte }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-10 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.commentaires.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-colors shadow-sm">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 font-medium transition-all shadow-md shadow-orange-500/20">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
