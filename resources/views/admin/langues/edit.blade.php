@extends('layouts.admin')

@section('title', 'Modifier Langue')
@section('page-title', 'Modifier la Langue')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center shadow-lg shadow-orange-500/20 text-white">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Modifier {{ $langue->nom_langue }}</h1>
                <p class="text-sm text-gray-500">Mettez à jour les informations et paramètres de la langue.</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.langues.index') }}" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-gray-600 font-medium hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm">
                Annuler
            </a>
            <button form="edit-langue-form" type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-xl font-medium shadow-lg shadow-orange-600/20 hover:bg-orange-700 hover:shadow-orange-600/30 transition-all flex items-center gap-2 transform active:scale-95">
                <span>Enregistrer</span>
                <svg class="w-4 h-4 text-orange-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form (2/3) -->
        <div class="lg:col-span-2">
            <form id="edit-langue-form" action="{{ route('admin.langues.update', $langue->id) }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                @csrf
                @method('PUT')

                <div class="p-8 space-y-8">
                    <!-- Identity Section -->
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            Identité de la langue
                        </h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Code -->
                            <div class="group">
                                <label for="code_langue" class="block text-sm font-medium text-gray-700 mb-1.5 transition-colors group-focus-within:text-orange-600">Code ISO</label>
                                <div class="relative">
                                    <input type="text" name="code_langue" id="code_langue" value="{{ old('code_langue', $langue->code_langue) }}" required maxlength="10"
                                           class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-gray-900 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-3 px-4 transition-all @error('code_langue') border-red-300 bg-red-50 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500 @enderror"
                                           placeholder="Ex: fr">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-400 text-xs font-mono uppercase border border-gray-200 rounded px-1.5 py-0.5 bg-white">ISO</span>
                                    </div>
                                </div>
                                @error('code_langue') <p class="mt-1.5 text-sm text-red-600 flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>{{ $message }}</p> @enderror
                            </div>

                            <!-- Nom -->
                            <div class="group">
                                <label for="nom_langue" class="block text-sm font-medium text-gray-700 mb-1.5 transition-colors group-focus-within:text-orange-600">Nom complet</label>
                                <input type="text" name="nom_langue" id="nom_langue" value="{{ old('nom_langue', $langue->nom_langue) }}" required maxlength="255"
                                       class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-gray-900 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-3 px-4 transition-all @error('nom_langue') border-red-300 bg-red-50 text-red-900 @enderror"
                                       placeholder="Ex: Français">
                                @error('nom_langue') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <hr class="border-gray-100">

                    <!-- Description Section -->
                    <div class="group">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2 transition-colors group-focus-within:text-orange-600">Description détaillée</label>
                        <div class="relative">
                            <textarea name="description" id="description" rows="5"
                                      class="block w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white text-gray-900 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm p-4 transition-all resize-none @error('description') border-red-300 bg-red-50 @enderror"
                                      placeholder="Ajoutez une description contextuelle pour cette langue...">{{ old('description', $langue->description) }}</textarea>
                            <div class="absolute bottom-3 right-3 text-xs text-gray-400 pointer-events-none">
                                Markdown supporté
                            </div>
                        </div>
                        @error('description') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="px-8 py-5 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-xs text-gray-500 flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Les champs marqués d'une astérisque sont obligatoires.
                    </span>
                </div>
            </form>
        </div>

        <!-- Sidebar Options (1/3) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Context Card -->
            <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-2xl p-6 shadow-lg text-white">
                <h3 class="font-bold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Statut rapide
                </h3>
                <div class="space-y-4 text-sm text-gray-300">
                    <div class="flex justify-between items-center pb-2 border-b border-gray-700">
                        <span>Créé le</span>
                        <span class="font-mono text-white">{{ $langue->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center pb-2 border-b border-gray-700">
                        <span>Dernière édit.</span>
                        <span class="font-mono text-white">{{ $langue->updated_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span>ID Interne</span>
                        <span class="bg-gray-700 px-2 py-0.5 rounded text-white text-xs font-mono">#{{ $langue->id }}</span>
                    </div>
                </div>
            </div>

            <!-- Help/Tips -->
            <div class="bg-orange-50 rounded-2xl p-6 border border-orange-100">
                <h4 class="text-orange-900 font-bold mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Conseil
                </h4>
                <p class="text-orange-800 text-sm leading-relaxed">
                    Le <strong>Code ISO</strong> est utilisé par le système pour les traductions automatiques. Assurez-vous qu'il respecte la norme (ex: 'fr', 'en-US').
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
