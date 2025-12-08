@extends('layouts.admin')

@section('title', 'Modifier le Média')
@section('page-title', 'Modifier le Média')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Modifier le Média</h2>
                <p class="text-sm text-gray-500 mt-1">Mettre à jour les informations ou remplacer le fichier.</p>
            </div>
            <a href="{{ route('admin.medias.index') }}" class="p-2 text-gray-400 hover:text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-full transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
        </div>

        <form action="{{ route('admin.medias.update', $media->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-8">
                <!-- Aperçu Actuel avec Design Amélioré -->
                <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                    <h3 class="text-sm font-semibold text-blue-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Fichier actuel
                    </h3>
                    @if($media->chemin)
                        <div class="flex items-start sm:items-center gap-6 flex-col sm:flex-row">
                            @php
                                $extension = pathinfo($media->chemin, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            @endphp

                            <div class="flex-shrink-0">
                            @if($isImage)
                                <img src="{{ asset('storage/' . $media->chemin) }}" alt="Aperçu" class="h-32 w-32 object-cover rounded-xl border-4 border-white shadow-md">
                            @else
                                <div class="h-32 w-32 flex items-center justify-center bg-white rounded-xl border-4 border-white shadow-md text-gray-500 font-bold uppercase text-xl">
                                    {{ $extension }}
                                </div>
                            @endif
                            </div>
                            
                            <div class="space-y-2">
                                <p class="text-sm text-blue-900 font-medium break-all">{{ basename($media->chemin) }}</p>
                                <a href="{{ asset('storage/' . $media->chemin) }}" target="_blank" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800 border border-blue-200 bg-white px-3 py-1 rounded-full hover:bg-blue-50 transition-colors">
                                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Voir le fichier original
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="text-yellow-600 text-sm">Aucun fichier associé (ce cas ne devrait pas arriver).</p>
                    @endif
                </div>

                <!-- Zone de Remplacement -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Remplacer le fichier (Optionnel)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-orange-500 hover:bg-orange-50 transition-all group cursor-pointer relative bg-gray-50">
                        <input type="file" name="fichier" id="fichier" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div class="space-y-1 text-center">
                            <div class="mx-auto h-10 w-10 text-gray-400 group-hover:text-orange-500 transition-colors">
                                <svg class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </div>
                            <div class="text-sm text-gray-600">
                                <span class="font-medium text-orange-600">Cliquez pour remplacer</span> ou glissez un nouveau fichier
                            </div>
                            <p id="filename" class="text-sm font-medium text-green-600 mt-2 hidden"></p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Type de Média -->
                    <div>
                        <label for="id_type_media" class="block text-sm font-semibold text-gray-700 mb-2">Type de média <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select name="id_type_media" id="id_type_media" class="appearance-none w-full rounded-xl border-gray-300 py-3 px-4 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors bg-white pr-10" required>
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ old('id_type_media', $media->id_type_media) == $type->id ? 'selected' : '' }}>
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
                    </div>

                    <!-- Contenu Associé -->
                    <div>
                        <label for="id_contenu" class="block text-sm font-semibold text-gray-700 mb-2">Contenu associé</label>
                        <div class="relative">
                            <select name="id_contenu" id="id_contenu" class="appearance-none w-full rounded-xl border-gray-300 py-3 px-4 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors bg-white pr-10">
                                <option value="">Aucun contenu lié</option>
                                @foreach($contenus as $contenu)
                                    <option value="{{ $contenu->id }}" {{ old('id_contenu', $media->id_contenu) == $contenu->id ? 'selected' : '' }}>
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
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description / Légende</label>
                    <textarea name="description" 
                              id="description" 
                              rows="4" 
                              class="w-full rounded-xl border-gray-300 focus:border-orange-500 focus:ring-orange-500 shadow-sm transition-colors p-4">{{ old('description', $media->description) }}</textarea>
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
                    Mettre à jour le média
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
            display.textContent = 'Nouveau fichier sélectionné : ' + fileName;
            display.classList.remove('hidden');
        } else {
            display.classList.add('hidden');
        }
    });
</script>
@endsection
