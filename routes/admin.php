<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LanguesController;
use App\Http\Controllers\Admin\RegionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UtilisateursController;
use App\Http\Controllers\Admin\ContenusController;
use App\Http\Controllers\Admin\CommentairesController;
use App\Http\Controllers\Admin\MediasController;
use App\Http\Controllers\Admin\TypeContenuController;
use App\Http\Controllers\Admin\TypeMediaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AchatsController;

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Langues
    Route::get('langues/api', [LanguesController::class, 'api'])->name('langues.api');
    Route::resource('langues', LanguesController::class);

    // Régions
    Route::get('regions/api', [RegionsController::class, 'api'])->name('regions.api');
    Route::resource('regions', RegionsController::class);

    // Rôles
    Route::get('roles/api', [RolesController::class, 'api'])->name('roles.api');
    Route::resource('roles', RolesController::class);

    // Utilisateurs
    Route::get('utilisateurs/api', [UtilisateursController::class, 'api'])->name('utilisateurs.api');
    Route::resource('utilisateurs', UtilisateursController::class);

    // Contenus
    Route::get('contenus/api', [ContenusController::class, 'api'])->name('contenus.api');
    Route::resource('contenus', ContenusController::class);
    Route::post('contenus/{contenu}/changer-statut', [ContenusController::class, 'changerStatut'])
        ->name('contenus.changer-statut');

    // Commentaires
    Route::get('commentaires/api', [CommentairesController::class, 'api'])->name('commentaires.api');
    Route::resource('commentaires', CommentairesController::class);

    // Paiements (Achats)
    Route::get('paiements/api', [AchatsController::class, 'api'])->name('paiements.api');
    Route::get('paiements', [AchatsController::class, 'index'])->name('paiements.index');
    Route::get('paiements/{id}', [AchatsController::class, 'show'])->name('paiements.show');

    // Médias
    Route::get('medias/api', [MediasController::class, 'api'])->name('medias.api');
    Route::resource('medias', MediasController::class);

    // Types de contenu
    Route::get('type-contenus/api', [TypeContenuController::class, 'api'])->name('typecontenus.api');
    Route::resource('type-contenus', TypeContenuController::class)->names([
        'index' => 'typecontenus.index',
        'create' => 'typecontenus.create',
        'store' => 'typecontenus.store',
        'show' => 'typecontenus.show',
        'edit' => 'typecontenus.edit',
        'update' => 'typecontenus.update',
        'destroy' => 'typecontenus.destroy'
    ]);

    // Types de médias
    Route::get('type-medias/api', [TypeMediaController::class, 'api'])->name('type-medias.api');
    Route::resource('type-medias', TypeMediaController::class)->names([
        'index' => 'type-medias.index',
        'create' => 'type-medias.create',
        'store' => 'type-medias.store',
        'show' => 'type-medias.show',
        'edit' => 'type-medias.edit',
        'update' => 'type-medias.update',
        'destroy' => 'type-medias.destroy'
    ]);
});
