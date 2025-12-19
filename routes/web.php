<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UtilisateursController;
use App\Http\Controllers\RegionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ContenusController;
use App\Http\Controllers\CommentairesController;
use App\Http\Controllers\MediasController;
use App\Http\Controllers\TypeContenuController;
use App\Http\Controllers\TypeMediaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil - React inline dans Blade
Route::get('/', function () {
    return view('welcome'); // Votre welcome.blade.php avec React inline
})->name('home');

// Page d'inscription - React inline dans Blade
Route::get('/register', function () {
    $langues = \App\Models\Langues::all();
    return view('auth.register', compact('langues'));
})->name('register');

// Page de connexion (vous pouvez la faire en Blade simple ou React)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Page de création admin (protéger en production)
Route::middleware('guest')->group(function () {
    Route::get('/create-admin', function () {
        // Vérifier si un admin existe déjà
        $adminExists = \App\Models\Utilisateurs::where('id_role', 1)->exists();

        if ($adminExists) {
            return redirect('/')->with('error', 'Un administrateur existe déjà.');
        }

        // Récupérer une langue par défaut
        $langue = \App\Models\Langues::first();

        return view('auth.register-admin', compact('langue'));
    })->name('create-admin');

    Route::post('/create-admin', function (Request $request) {
        // Validation
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|min:8|confirmed',
            'id_langue' => 'required|exists:langues,id',
        ]);

        // Créer l'admin
        $admin = \App\Models\Utilisateurs::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->password),
            'sexe' => 'H',
            'date_naissance' => '1990-01-01',
            'date_inscription' => now(),
            'statut' => 'actif',
            'id_langue' => $request->id_langue,
            'id_role' => 1, // Rôle admin
        ]);

        return redirect('/login')->with('success', 'Compte administrateur créé avec succès !');
    });
});

/*
|--------------------------------------------------------------------------
| Routes API pour React
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {
    // Inscription via API (pour React inline)
    Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'store']);

    // Connexion via API
    Route::post('/login', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);

    // Données pour les formulaires
    Route::get('/langues', function () {
        return response()->json(\App\Models\Langues::all());
    });
});

/*
|--------------------------------------------------------------------------
| Routes Authentifiées
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ma Bibliothèque (Achats)
    Route::get('/ma-bibliotheque', [App\Http\Controllers\BibliothequeController::class, 'index'])->name('bibliotheque.index');

    // Paiements
    Route::post('/paiement/initier', [App\Http\Controllers\PaiementController::class, 'initier'])->name('paiement.initier');
    Route::match(['get', 'post'], '/paiement/callback', [App\Http\Controllers\PaiementController::class, 'callback'])->name('paiement.callback');
    
    // Favoris
    Route::post('/favoris/{id}', [App\Http\Controllers\FavorisController::class, 'toggle'])->name('favoris.toggle');
});

// Routes Publiques (Catalogue)
Route::get('/catalogue', [App\Http\Controllers\CatalogueController::class, 'index'])->name('catalogue.index');
Route::get('/contenu/{slug}', [App\Http\Controllers\CatalogueController::class, 'show'])->name('catalogue.show');

// Catch-all route pour SPA React (si vous voulez une SPA)
// Attention : cette route doit être en dernier
Route::get('/{any}', function () {
    return view('welcome'); // Redirige vers la page d'accueil React
})->where('any', '^(?!admin).*$')->name('spa-fallback');

// Inclure les routes d'authentification
require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Routes Espace Contributeur / Abonnement
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/contributeur/abonnement', [App\Http\Controllers\ContributorSubscriptionController::class, 'index'])->name('contributeur.abonnement');
    Route::get('/contributeur/paiement/initier', [App\Http\Controllers\ContributorSubscriptionController::class, 'initier'])->name('contributeur.paiement.initier'); // GET pour simplifier le lien, POST recommandé en prod
    Route::match(['get', 'post'], '/contributeur/paiement/callback', [App\Http\Controllers\ContributorSubscriptionController::class, 'callback'])->name('contributeur.paiement.callback');
});
