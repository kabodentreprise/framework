<div class="flex justify-end gap-2">
    <!-- Voir (Bleu) -->
    <a href="{{ route('admin.contenus.show', $item->id) }}" class="p-1 px-2 text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Voir">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
    </a>

    <!-- Modifier (Jaune/Amber) -->
    <a href="{{ route('admin.contenus.edit', $item->id) }}" class="p-1 px-2 text-amber-500 hover:bg-amber-50 rounded transition-colors" title="Modifier">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>
    </a>
    
    <!-- Supprimer (Rouge) -->
    <form action="{{ route('admin.contenus.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce contenu ?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="p-1 px-2 text-red-600 hover:bg-red-50 rounded transition-colors" title="Supprimer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    </form>
</div>
