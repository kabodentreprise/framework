@extends('layouts.admin')

@section('title', 'Créer une Langue')
@section('page-title', 'Créer une Langue')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">Nouvelle Langue</h2>
        <p class="text-sm text-gray-500">Ajouter une nouvelle langue au système.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gray-50 flex items-center">
            <div class="bg-orange-100 p-2 rounded-lg mr-3">
                <svg class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900">Informations de la Langue</h3>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.langues.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="code_langue" class="block text-sm font-medium text-gray-700 mb-1">Code de la langue <span class="text-red-500">*</span></label>
                        <input type="text" name="code_langue" id="code_langue" value="{{ old('code_langue') }}" required
                               placeholder="Ex: fr, en" maxlength="10"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('code_langue') border-red-500 @enderror">
                        @error('code_langue') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-gray-500">Code ISO court (ex: fr)</p>
                    </div>

                    <div>
                        <label for="nom_langue" class="block text-sm font-medium text-gray-700 mb-1">Nom de la langue <span class="text-red-500">*</span></label>
                        <input type="text" name="nom_langue" id="nom_langue" value="{{ old('nom_langue') }}" required
                               placeholder="Ex: Français" maxlength="255"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('nom_langue') border-red-500 @enderror">
                        @error('nom_langue') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm py-2.5 @error('description') border-red-500 @enderror"
                              placeholder="Description optionnelle...">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.langues.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        Annuler
                    </a>
                    <button type="submit" class="px-5 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                        Créer la langue
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
