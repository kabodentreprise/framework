<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenus;
use App\Models\TypeContenus;
use App\Models\Regions;
use Illuminate\Support\Facades\Auth;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Contenus::with(['typeContenu', 'auteur', 'region'])
                         ->where('statut', 'publié');

        // FILTRE : Si connecté, masquer les contenus déjà achetés
        if ($user) {
            $query->whereDoesntHave('achats', function ($q) use ($user) {
                $q->where('id_utilisateur', $user->id)
                  ->where('statut', 'payé');
            });
        }

        // Filtres optionnels (Type, Recherche)
        if ($request->has('type')) {
            $query->whereHas('typeContenu', function ($q) use ($request) {
                $q->where('nom_contenu', $request->type);
            });
        }
        
        if ($request->has('q')) {
            $query->where('titre', 'like', '%' . $request->q . '%');
        }

        $contenus = $query->latest()->paginate(12);
        $types = TypeContenus::all();

        return view('catalogue.index', compact('contenus', 'types'));
    }

    public function show($slug)
    {
        $contenu = Contenus::with(['typeContenu', 'auteur', 'medias', 'region'])
                           ->where('slug', $slug)
                           ->where('statut', 'publié')
                           ->firstOrFail();

        $user = Auth::user();

        // Vérification des droits d'accès
        $accesAutorise = false;

        if ($contenu->estGratuit()) {
            $accesAutorise = true;
        } elseif ($user && $contenu->estAchetePar($user->id)) {
            $accesAutorise = true;
        }

        // Si c'est l'auteur ou un admin, accès total
        if ($user && ($user->id === $contenu->id_auteur || $user->isAdmin())) {
            $accesAutorise = true;
        }

        return view('catalogue.show', compact('contenu', 'accesAutorise'));
    }
}
