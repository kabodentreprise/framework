<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Utilisateurs;
use App\Models\Langues;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        $langues = Langues::all();
        return view('auth.register', compact('langues'));
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:utilisateurs,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'sexe' => ['required', 'in:M,F,Autre'],
            'date_nais' => ['required', 'date', 'before:-18 years'],
            'id_langue' => ['required', 'exists:langues,id'], // Vérifiez si c'est 'langues' ou 'langue'
        ], [
            'date_nais.before' => 'Vous devez avoir au moins 18 ans pour vous inscrire.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'id_langue.exists' => 'La langue sélectionnée n\'existe pas.',
        ]);

        // Création de l'utilisateur
        $utilisateur = Utilisateurs::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->password), // Champ 'mot_de_passe' dans la BD
            'sexe' => $request->sexe,
            'date_naissance' => $request->date_nais,
            'date_inscription' => now(),
            'statut' => 'actif',
            'id_langue' => $request->id_langue,
            'id_role' => 2, // Rôle utilisateur par défaut
        ]);

        // Événement d'inscription
        event(new Registered($utilisateur));

        // Réponse selon le type de requête
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Votre compte a été créé avec succès !',
                'redirect' => route('login')
            ], 201);
        }

        // Redirection classique
        return redirect()->route('login')
            ->with('success', 'Votre compte a été créé avec succès ! Vous pouvez maintenant vous connecter.');
    }
}
