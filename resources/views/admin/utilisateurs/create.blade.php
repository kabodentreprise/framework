@extends('layouts.admin')

@section('title', 'Nouvel Utilisateur')
@section('page-title', 'Nouvel Utilisateur')

@section('content')
<div class="max-w-7xl mx-auto">
    <form action="{{ route('admin.utilisateurs.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
        @csrf
        
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column: Main Info -->
            <div class="flex-1 space-y-6">
                <!-- Personal Info Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50 flex items-center">
                        <div class="bg-orange-100 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Informations Personnelles</h3>
                    </div>
                    
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Photo Upload (Full Width) -->
                        <div class="md:col-span-2 flex items-center mb-4">
                            <div class="h-20 w-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 overflow-hidden mr-6 flex-shrink-0 border-2 border-dashed border-gray-300">
                                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                                <input type="file" name="photo" id="photo" accept="image/*"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 transition cursor-pointer">
                                <p class="mt-1 text-xs text-gray-500">JPG, PNG ou GIF (Max. 2MB)</p>
                                @error('photo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom <span class="text-red-500">*</span></label>
                            <input type="text" name="prenom" id="prenom" value="{{ old('prenom') }}" required placeholder="Ex: Jean"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('prenom') border-red-500 @enderror">
                            @error('prenom') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                            <input type="text" name="nom" id="nom" value="{{ old('nom') }}" required placeholder="Ex: Dupont"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('nom') border-red-500 @enderror">
                            @error('nom') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="jean.dupont@exemple.com" autocomplete="off"
                                       class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('email') border-red-500 @enderror">
                            </div>
                            @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="sexe" class="block text-sm font-medium text-gray-700 mb-1">Sexe <span class="text-red-500">*</span></label>
                            <select name="sexe" id="sexe" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('sexe') border-red-500 @enderror">
                                <option value="">Sélectionnez...</option>
                                <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Homme</option>
                                <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Femme</option>
                            </select>
                            @error('sexe') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        
                        <div>
                             <label for="date_naissance" class="block text-sm font-medium text-gray-700 mb-1">Date de Naissance <span class="text-red-500">*</span></label>
                             <input type="date" name="date_naissance" id="date_naissance" value="{{ old('date_naissance') }}" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('date_naissance') border-red-500 @enderror">
                             @error('date_naissance') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Settings -->
            <div class="lg:w-96 space-y-6">
                <!-- Account Settings -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50 flex items-center">
                        <div class="bg-indigo-100 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Paramètres</h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="id_role" class="block text-sm font-medium text-gray-700 mb-1">Rôle <span class="text-red-500">*</span></label>
                            <select name="id_role" id="id_role" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('id_role') border-red-500 @enderror">
                                <option value="">Sélectionnez un rôle...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('id_role') == $role->id ? 'selected' : '' }}>
                                        {{ $role->nom_role }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_role') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="statut" class="block text-sm font-medium text-gray-700 mb-1">Statut <span class="text-red-500">*</span></label>
                            <select name="statut" id="statut" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('statut') border-red-500 @enderror">
                                <option value="actif" {{ old('statut') == 'actif' ? 'selected' : '' }}>Actif</option>
                                <option value="suspendu" {{ old('statut') == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                                <option value="restreint" {{ old('statut') == 'restreint' ? 'selected' : '' }}>Restreint</option>
                            </select>
                            @error('statut') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="id_langue" class="block text-sm font-medium text-gray-700 mb-1">Langue <span class="text-red-500">*</span></label>
                            <select name="id_langue" id="id_langue" required
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('id_langue') border-red-500 @enderror">
                                <option value="">Choisir...</option>
                                @foreach($langues as $langue)
                                    <option value="{{ $langue->id }}" {{ old('id_langue') == $langue->id ? 'selected' : '' }}>
                                        {{ $langue->nom_langue }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_langue') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Security -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-5 border-b border-gray-100 bg-gray-50 flex items-center">
                        <div class="bg-red-100 p-2 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Sécurité</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="mot_de_passe" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe <span class="text-red-500">*</span></label>
                            <input type="password" name="mot_de_passe" id="mot_de_passe" required autocomplete="new-password"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('mot_de_passe') border-red-500 @enderror">
                            @error('mot_de_passe') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="mot_de_passe_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer <span class="text-red-500">*</span></label>
                            <input type="password" name="mot_de_passe_confirmation" id="mot_de_passe_confirmation" required
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5">
                        </div>
                    </div>
                </div>

                <!-- Action Buttons (Sticky or just at bottom) -->
                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('admin.utilisateurs.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                        Créer l'utilisateur
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
