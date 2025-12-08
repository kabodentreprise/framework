<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateurs;
use App\Models\Roles;
use App\Models\Langues;
use App\Http\Requests\StoreUtilisateurRequest;
use App\Http\Requests\UpdateUtilisateurRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class UtilisateursController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Utilisateurs::with(['role', 'langue'])
            ->select(['id', 'nom', 'prenom', 'email', 'sexe', 'date_inscription', 'date_naissance', 'statut', 'id_role', 'id_langue']);

        // Filtrage
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('role')) {
            $query->where('id_role', $request->role);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'date_inscription');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $utilisateurs = $query->paginate(15)->withQueryString();
        $roles = Roles::all();

        return view('admin.utilisateurs.index', compact('utilisateurs', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Roles::all();
        $langues = Langues::all();

        return view('admin.utilisateurs.create', compact('roles', 'langues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUtilisateurRequest $request)
    {
        try {
            $data = $request->validated();

            // Gestion de la photo
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('utilisateurs/photos', 'public');
                $data['photo'] = $photoPath;
            }

            // Hash du mot de passe
            $data['mot_de_passe'] = Hash::make($data['mot_de_passe']);

            // Date d'inscription
            $data['date_inscription'] = now();

            $utilisateur = Utilisateurs::create($data);

            return redirect()->route('admin.utilisateurs.index')
                ->with('success', 'Utilisateur créé avec succès.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $utilisateur = Utilisateurs::with([
                'role',
                'langue',
                'contenus' => function($query) {
                    $query->latest()->limit(10);
                },
                'commentaires' => function($query) {
                    $query->latest()->limit(10);
                }
            ])
            ->findOrFail($id);

        // Vérifier les permissions (si Gate est configuré)
        if (class_exists(Gate::class) && method_exists(Gate::class, 'allows')) {
            if (!Gate::allows('view_utilisateur', $utilisateur)) {
                abort(403, 'Accès non autorisé');
            }
        }

        return view('admin.utilisateurs.show', compact('utilisateur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $utilisateur = Utilisateurs::findOrFail($id);

        // Vérifier les permissions (si Gate est configuré)
        if (class_exists(Gate::class) && method_exists(Gate::class, 'allows')) {
            if (!Gate::allows('edit_utilisateur', $utilisateur)) {
                abort(403, 'Accès non autorisé');
            }
        }

        $roles = Roles::all();
        $langues = Langues::all();

        return view('admin.utilisateurs.edit', compact('utilisateur', 'roles', 'langues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUtilisateurRequest $request, $id)
    {
        $utilisateur = Utilisateurs::findOrFail($id);

        // Vérifier les permissions (si Gate est configuré)
        if (class_exists(Gate::class) && method_exists(Gate::class, 'allows')) {
            if (!Gate::allows('edit_utilisateur', $utilisateur)) {
                abort(403, 'Accès non autorisé');
            }
        }

        try {
            $data = $request->validated();

            // Gestion du mot de passe
            if ($request->filled('mot_de_passe')) {
                $data['mot_de_passe'] = Hash::make($data['mot_de_passe']);
            } else {
                unset($data['mot_de_passe']);
            }

            // Gestion de la photo
            if ($request->hasFile('photo')) {
                // Supprimer l'ancienne photo
                if ($utilisateur->photo) {
                    Storage::disk('public')->delete($utilisateur->photo);
                }

                $photoPath = $request->file('photo')->store('utilisateurs/photos', 'public');
                $data['photo'] = $photoPath;
            } elseif ($request->has('remove_photo')) {
                // Supprimer la photo existante
                if ($utilisateur->photo) {
                    Storage::disk('public')->delete($utilisateur->photo);
                }
                $data['photo'] = null;
            }

            $utilisateur->update($data);

            return redirect()->route('admin.utilisateurs.index')
                ->with('success', 'Utilisateur mis à jour avec succès.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Erreur lors de la mise à jour : ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $utilisateur = Utilisateurs::findOrFail($id);

        // Vérifier les permissions (si Gate est configuré)
        if (class_exists(Gate::class) && method_exists(Gate::class, 'allows')) {
            if (!Gate::allows('delete_utilisateur', $utilisateur)) {
                abort(403, 'Accès non autorisé');
            }
        }

        // Empêcher la suppression de soi-même
        if ($utilisateur->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        // Empêcher la suppression du dernier administrateur
        if ($utilisateur->estAdministrateur() && Utilisateurs::where('id_role', 1)->count() <= 1) {
            return back()->with('error', 'Impossible de supprimer le dernier administrateur.');
        }

        try {
            // Supprimer la photo
            if ($utilisateur->photo) {
                Storage::disk('public')->delete($utilisateur->photo);
            }

            $utilisateur->delete();

            return redirect()->route('admin.utilisateurs.index')
                ->with('success', 'Utilisateur supprimé avec succès.');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    /**
     * Toggle user status (activation/suspension)
     */
    public function toggleStatus(Request $request, $id)
    {
        $utilisateur = Utilisateurs::findOrFail($id);

        // Vérifier les permissions (si Gate est configuré)
        if (class_exists(Gate::class) && method_exists(Gate::class, 'allows')) {
            if (!Gate::allows('edit_utilisateur', $utilisateur)) {
                return response()->json(['error' => 'Non autorisé'], 403);
            }
        }

        $newStatus = $utilisateur->statut === 'actif' ? 'suspendu' : 'actif';

        $utilisateur->update(['statut' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => "Statut mis à jour: {$newStatus}",
            'statut' => $newStatus,
            'statut_formate' => $utilisateur->statut_formate
        ]);
    }

    /**
     * API pour DataTables
     */
    public function api(Request $request)
    {
        // Vérifier les permissions (vérification simplifiée)
        if (!auth()->check()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        // Vérifier si l'utilisateur est administrateur
        $user = auth()->user();
        if (!$user->estAdministrateur()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $query = Utilisateurs::with(['role', 'langue'])
            ->select(['id', 'nom', 'prenom', 'email', 'sexe', 'date_inscription', 'date_naissance', 'statut', 'id_role', 'id_langue']);

        // Filtrage côté serveur pour DataTables
        if ($request->has('search') && $request->search['value']) {
            $search = $request->search['value'];
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('role', function($roleQuery) use ($search) {
                      $roleQuery->where('nom_role', 'like', "%{$search}%");
                  });
            });
        }

        // Tri
        if ($request->has('order')) {
            $columns = $request->columns;
            foreach ($request->order as $order) {
                $columnIndex = $order['column'];
                $columnData = $columns[$columnIndex]['data'];
                $columnName = $columns[$columnIndex]['name']; // Use name if available
                $direction = $order['dir'];

                // Mapping pour le tri
                if ($columnData === 'nom_complet') {
                    $query->orderBy('nom', $direction)->orderBy('prenom', $direction);
                } elseif ($columnData === 'role' || $columnName === 'role.nom_role') {
                    // Tri par ID de rôle pour l'instant (plus simple)
                    // Pour trier par nom de rôle, il faudrait un join
                    $query->orderBy('id_role', $direction);
                } elseif ($columnData === 'actions') {
                    continue;
                } else {
                    // Sécurité : éviter l'injection SQL indirecte, vérifier si la colonne existe
                    // Ou utiliser $columnName qui correspond souvent à la colonne DB
                    $validColumns = ['nom', 'prenom', 'email', 'sexe', 'date_inscription', 'date_naissance', 'statut', 'id_role', 'id_langue'];
                    
                    if (in_array($columnName, $validColumns)) {
                         $query->orderBy($columnName, $direction);
                    } elseif (in_array($columnData, $validColumns)) {
                         $query->orderBy($columnData, $direction);
                    }
                }
            }
        }

        $total = $query->count();
        $utilisateurs = $query->skip($request->start)->take($request->length)->get();

        $data = $utilisateurs->map(function ($utilisateur) {
            return [
                'id' => $utilisateur->id,
                'nom_complet' => e($utilisateur->nom_complet),
                'email' => e($utilisateur->email),
                'sexe' => $utilisateur->sexe_formate,
                'age' => $utilisateur->age,
                'date_inscription' => $utilisateur->date_inscription->format('d/m/Y H:i'),
                'statut' => '<span class="badge bg-' . $utilisateur->statut_couleur . '">' . $utilisateur->statut_formate . '</span>',
                'role' => $utilisateur->role->nom_role ?? 'N/A',
                'langue' => $utilisateur->langue->nom_langue ?? 'N/A',
                'actions' => view('partials.actions-utilisateur', compact('utilisateur'))->render()
            ];
        });

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ]);
    }

    /**
     * Export users
     */
    public function export(Request $request)
    {
        // Vérifier les permissions (si Gate est configuré)
        if (class_exists(Gate::class) && method_exists(Gate::class, 'allows')) {
            if (!Gate::allows('export_utilisateurs')) {
                abort(403, 'Accès non autorisé');
            }
        }

        $utilisateurs = Utilisateurs::with(['role', 'langue'])->get();

        $csvData = "ID,Nom,Prénom,Email,Sexe,Âge,Date d'inscription,Statut,Rôle,Langue\n";

        foreach ($utilisateurs as $utilisateur) {
            $csvData .= implode(',', [
                $utilisateur->id,
                e($utilisateur->nom),
                e($utilisateur->prenom),
                e($utilisateur->email),
                $utilisateur->sexe_formate,
                $utilisateur->age,
                $utilisateur->date_inscription->format('d/m/Y'),
                $utilisateur->statut_formate,
                $utilisateur->role->nom_role ?? '',
                $utilisateur->langue->nom_langue ?? ''
            ]) . "\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="utilisateurs_' . date('Y-m-d') . '.csv"');
    }
}