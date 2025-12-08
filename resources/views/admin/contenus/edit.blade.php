@extends('layouts.admin')

@section('title', 'Modifier le Contenu')
@section('page-title', 'Modifier le Contenu')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Modifier le Contenu</h2>
                <p class="text-sm text-gray-500 mt-1">Mise à jour des informations.</p>
            </div>
            <a href="{{ route('admin.contenus.index') }}" class="p-2 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        <form action="{{ route('admin.contenus.update', $contenu->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Titre -->
                <div>
                    <label for="titre" class="block text-sm font-semibold text-gray-700 mb-2">Titre du contenu <span class="text-red-500">*</span></label>
                    <input type="text" 
                           name="titre" 
                           id="titre" 
                           class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors"
                           value="{{ old('titre', $contenu->titre) }}" 
                           required>
                    @error('titre')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type de Contenu -->
                    <div>
                        <label for="id_type_contenu" class="block text-sm font-semibold text-gray-700 mb-2">Type <span class="text-red-500">*</span></label>
                        <select name="id_type_contenu" id="id_type_contenu" class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors" required>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('id_type_contenu', $contenu->id_type_contenu) == $type->id ? 'selected' : '' }}>
                                    {{ $type->nom_contenu }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Statut -->
                    <div>
                        <label for="statut" class="block text-sm font-semibold text-gray-700 mb-2">Statut <span class="text-red-500">*</span></label>
                        <select name="statut" id="statut" class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors" required>
                            <option value="brouillon" {{ old('statut', $contenu->statut) == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                            <option value="en_attente" {{ old('statut', $contenu->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                            <option value="publié" {{ old('statut', $contenu->statut) == 'publié' ? 'selected' : '' }}>Publié</option>
                            <option value="rejeté" {{ old('statut', $contenu->statut) == 'rejeté' ? 'selected' : '' }}>Rejeté</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Auteur -->
                    <div>
                        <label for="id_auteur" class="block text-sm font-semibold text-gray-700 mb-2">Auteur <span class="text-red-500">*</span></label>
                        <select name="id_auteur" id="id_auteur" class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors" required>
                            @foreach($auteurs as $auteur)
                                <option value="{{ $auteur->id }}" {{ old('id_auteur', $contenu->id_auteur) == $auteur->id ? 'selected' : '' }}>
                                    {{ $auteur->getFullName() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Région -->
                    <div>
                        <label for="id_region" class="block text-sm font-semibold text-gray-700 mb-2">Région <span class="text-red-500">*</span></label>
                        <select name="id_region" id="id_region" class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors" required>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ old('id_region', $contenu->id_region) == $region->id ? 'selected' : '' }}>
                                    {{ $region->nom_region }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Langue -->
                    <div>
                        <label for="id_langue" class="block text-sm font-semibold text-gray-700 mb-2">Langue <span class="text-red-500">*</span></label>
                        <select name="id_langue" id="id_langue" class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors" required>
                            @foreach($langues as $langue)
                                <option value="{{ $langue->id }}" {{ old('id_langue', $contenu->id_langue) == $langue->id ? 'selected' : '' }}>
                                    {{ $langue->nom_langue }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Texte -->
                <div>
                    <label for="texte" class="block text-sm font-semibold text-gray-700 mb-2">Contenu <span class="text-red-500">*</span></label>
                    <textarea name="texte" 
                              id="texte" 
                              rows="10" 
                              class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors"
                              required>{{ old('texte', $contenu->texte) }}</textarea>
                </div>

                <!-- Paramètres d'accès et de Prix -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Paramètres d'accès</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Type d'accès -->
                        <div>
                            <span class="block text-sm font-semibold text-gray-700 mb-2">Type d'accès <span class="text-red-500">*</span></span>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type_acces" value="gratuit" class="form-radio text-orange-600 focus:ring-orange-500 border-gray-300" {{ (old('type_acces') ?? $contenu->type_acces) == 'gratuit' ? 'checked' : '' }} onchange="togglePrixField()">
                                    <span class="ml-2 text-gray-700">Gratuit</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="type_acces" value="payant" class="form-radio text-orange-600 focus:ring-orange-500 border-gray-300" {{ (old('type_acces') ?? $contenu->type_acces) == 'payant' ? 'checked' : '' }} onchange="togglePrixField()">
                                    <span class="ml-2 text-gray-700">Payant</span>
                                </label>
                            </div>
                            @error('type_acces')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Prix (Masaqué si gratuit) -->
                        <div id="prix-container" class="{{ (old('type_acces') ?? $contenu->type_acces) == 'payant' ? '' : 'hidden' }}">
                            <label for="prix" class="block text-sm font-semibold text-gray-700 mb-2">Prix (FCFA) <span class="text-red-500">*</span></label>
                            <div class="relative rounded-md shadow-sm">
                                <input type="number" 
                                       name="prix" 
                                       id="prix" 
                                       min="0" 
                                       step="100"
                                       class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors pr-12"
                                       placeholder="Ex: 500"
                                       value="{{ old('prix') ?? $contenu->prix }}">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">FCFA</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Montant minimum recommandé : 100 FCFA</p>
                            @error('prix')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <script>
                    function togglePrixField() {
                        const isPayant = document.querySelector('input[name="type_acces"]:checked').value === 'payant';
                        const prixContainer = document.getElementById('prix-container');
                        if (isPayant) {
                            prixContainer.classList.remove('hidden');
                        } else {
                            prixContainer.classList.add('hidden');
                        }
                    }
                    // Run on load
                    document.addEventListener('DOMContentLoaded', togglePrixField);
                </script>

            </div>

            <div class="flex justify-end gap-3 mt-10 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.contenus.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-colors shadow-sm">
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
