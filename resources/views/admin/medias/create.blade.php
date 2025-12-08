@extends('layouts.admin')

@section('title', 'Ajouter un Média')
@section('page-title', 'Ajouter un Média')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Nouveau Média</h2>
                <p class="text-sm text-gray-500 mt-1">Ajoutez une image, une vidéo ou un document à la médiathèque.</p>
            </div>
            <a href="{{ route('admin.medias.index') }}" class="p-2 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        <form action="{{ route('admin.medias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-8">
                <!-- Zone d'upload professionnelle -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Fichier Média <span class="text-red-500">*</span></label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-orange-500 hover:bg-orange-50 transition-all group cursor-pointer relative">
                        <input type="file" name="fichier" id="fichier" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                        <div class="space-y-1 text-center">
                            <div class="mx-auto h-12 w-12 text-gray-400 group-hover:text-orange-500 transition-colors">
                                <svg class="w-full h-full" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <span class="relative cursor-pointer bg-white rounded-md font-medium text-orange-600 hover:text-orange-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-orange-500 px-1">
                                    Téléverser un fichier
                                </span>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, PDF, MP4 jusqu'à 10MB
                            </p>
                            <p id="filename" class="text-sm font-medium text-green-600 mt-2 hidden"></p>
                        </div>
                    </div>
                    @error('fichier')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type de Média -->
                    <div>
                        <label for="id_type_media" class="block text-sm font-semibold text-gray-700 mb-2">Type de média <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="id_type_media" id="id_type_media" class="appearance-none w-full rounded-xl border-gray-300 py-3 px-4 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors bg-white pr-10" required>
                                <option value="">Sélectionner un type...</option>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('id_type_media') == $type->id ? 'selected' : '' }}>
                                        {{ $type->nom_media }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        @error('id_type_media')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Contenu Associé -->
                    <div>
                        <label for="id_contenu" class="block text-sm font-semibold text-gray-700 mb-2">Contenu associé</label>
                        <div class="relative">
                            <select name="id_contenu" id="id_contenu" class="appearance-none w-full rounded-xl border-gray-300 py-3 px-4 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors bg-white pr-10">
                                <option value="">Aucun contenu lié</option>
                                @foreach($contenus as $contenu)
                                    <option value="{{ $contenu->id }}" {{ old('id_contenu') == $contenu->id ? 'selected' : '' }}>
                                        {{ $contenu->titre }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        @error('id_contenu')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description / Légende</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4" 
                              placeholder="Décrivez ce média..."
                              class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors p-4">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-10 pt-6 border-t border-gray-100">
                <a href="{{ route('admin.medias.index') }}" class="px-6 py-2.5 bg-white border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-medium transition-colors shadow-sm">
                    Annuler
                </a>
                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 font-medium transition-all shadow-md shadow-orange-500/20 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Enregistrer le média
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('fichier').addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : '';
        const display = document.getElementById('filename');
        if (fileName) {
            display.textContent = 'Fichier sélectionné : ' + fileName;
            display.classList.remove('hidden');
        } else {
            display.classList.add('hidden');
        }
    });
</script>
@endsection
