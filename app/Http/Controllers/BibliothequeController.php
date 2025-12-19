<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contenus;
use App\Models\Achats;

class BibliothequeController extends Controller
{
    /**
     * Affiche la bibliothèque de l'utilisateur (contenus achetés)
     */
    public function index()
    {
        $user = Auth::user();

        // Récupérer les IDs des contenus achetés
        $achats = Achats::where('id_utilisateur', $user->id)
            ->where('statut', 'payé')
            ->whereNotNull('id_contenu') // Exclure les abonnements
            ->pluck('id_contenu');

        // Récupérer les contenus complets
        $contenus = Contenus::with(['auteur', 'typeContenu'])
            ->whereIn('id', $achats)
            ->latest()
            ->paginate(12);

        return view('bibliotheque.index', compact('contenus'));
    }
}
