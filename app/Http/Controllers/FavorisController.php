<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contenus;

class FavorisController extends Controller
{
    public function toggle(Request $request, $id)
    {
        $user = Auth::user();
        $contenu = Contenus::findOrFail($id);

        // Vérifier si déjà en favoris (relation à définir dans Utilisateurs/Contenus)
        // Mais ici on peut faire une requête directe si la relation n'est pas encore définie dans le modèle
        $exists = \DB::table('favoris')
            ->where('id_utilisateur', $user->id)
            ->where('id_contenu', $contenu->id)
            ->exists();

        if ($exists) {
            \DB::table('favoris')
                ->where('id_utilisateur', $user->id)
                ->where('id_contenu', $contenu->id)
                ->delete();
            $message = 'Contenu retiré des favoris.';
            $status = 'removed';
        } else {
            \DB::table('favoris')->insert([
                'id_utilisateur' => $user->id,
                'id_contenu' => $contenu->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $message = 'Contenu ajouté aux favoris.';
            $status = 'added';
        }

        return back()->with('success', $message);
    }
}
