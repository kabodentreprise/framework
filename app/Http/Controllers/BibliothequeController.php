<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Achats;

class BibliothequeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupérer les achats payés de l'utilisateur avec le contenu associé
        $achats = Achats::with(['contenu', 'contenu.auteur', 'contenu.typeContenu'])
            ->where('id_utilisateur', $user->id)
            ->where('statut', 'payé')
            ->latest()
            ->paginate(12);

        return view('user.bibliotheque', compact('achats'));
    }
}
