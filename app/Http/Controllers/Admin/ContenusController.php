<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contenus;
use App\Models\TypeContenus;
use App\Models\Utilisateurs;
use App\Models\Regions;
use App\Models\Langues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ContenusController extends Controller
{
    public function api(Request $request)
    {
        $query = Contenus::with(['typeContenu', 'auteur', 'region', 'langue'])->select('contenus.*');

        return datatables()->of($query)
            ->addColumn('actions', function ($item) {
                return view('partials.actions-contenu', compact('item'))->render();
            })
            ->editColumn('titre', function ($item) {
                return '<div class="flex flex-col">
                            <span class="font-bold text-gray-900">' . e($item->titre) . '</span>
                            <span class="text-xs text-gray-500">ID: ' . $item->id . '</span>
                        </div>';
            })
            ->editColumn('type_contenu', function ($item) {
                $html = $item->typeContenu ? 
                    '<span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">' . e($item->typeContenu->nom_contenu) . '</span>' 
                    : '-';
                
                if ($item->type_acces === 'payant') {
                    $html .= ' <span class="ml-1 px-2 py-1 text-xs font-bold rounded-full bg-purple-100 text-purple-700" title="' . $item->prix . ' FCFA">Payant</span>';
                }
                return $html;
            })
            ->editColumn('statut', function ($item) {
                $colors = [
                    'brouillon' => 'bg-gray-100 text-gray-800',
                    'en_attente' => 'bg-yellow-100 text-yellow-800',
                    'publié' => 'bg-green-100 text-green-800',
                    'rejeté' => 'bg-red-100 text-red-800'
                ];
                $color = $colors[$item->statut] ?? 'bg-gray-100 text-gray-800';
                return '<span class="px-2 py-1 text-xs font-semibold rounded-full ' . $color . '">' . ucfirst(str_replace('_', ' ', $item->statut)) . '</span>';
            })
            ->editColumn('auteur', function ($item) {
                return $item->auteur ? e($item->auteur->getFullName()) : '-';
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at ? $item->created_at->format('d/m/Y') : '-';
            })
            ->rawColumns(['actions', 'titre', 'type_contenu', 'statut'])
            ->make(true);
    }

    public function index()
    {
        return view('admin.contenus.index');
    }

    public function create()
    {
        $types = TypeContenus::all();
        $regions = Regions::all();
        $langues = Langues::all();
        $auteurs = Utilisateurs::all(); // On pourrait filtrer par rôles si besoin
        
        return view('admin.contenus.create', compact('types', 'regions', 'langues', 'auteurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'statut' => 'required|in:brouillon,en_attente,publié,rejeté',
            'id_type_contenu' => 'required|exists:type_contenus,id',
            'id_region' => 'required|exists:regions,id',
            'id_langue' => 'required|exists:langues,id',
            'id_auteur' => 'required|exists:utilisateurs,id',
            'type_acces' => 'required|in:gratuit,payant',
            'prix' => 'nullable|required_if:type_acces,payant|numeric|min:0',
        ]);

        // Si gratuit, on force le prix à null
        if ($validated['type_acces'] === 'gratuit') {
            $validated['prix'] = null;
        }

        $validated['slug'] = \Str::slug($validated['titre']);
        $validated['date_creation'] = now();

        Contenus::create($validated);

        return redirect()->route('admin.contenus.index')->with('success', 'Contenu créé avec succès.');
    }

    public function show($id)
    {
        $contenu = Contenus::with(['typeContenu', 'auteur', 'region', 'langue', 'medias'])->findOrFail($id);
        return view('admin.contenus.show', compact('contenu'));
    }

    public function edit($id)
    {
        $contenu = Contenus::findOrFail($id);
        $types = TypeContenus::all();
        $regions = Regions::all();
        $langues = Langues::all();
        $auteurs = Utilisateurs::all();

        return view('admin.contenus.edit', compact('contenu', 'types', 'regions', 'langues', 'auteurs'));
    }

    public function update(Request $request, $id)
    {
        $contenu = Contenus::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'texte' => 'required|string',
            'statut' => 'required|in:brouillon,en_attente,publié,rejeté',
            'id_type_contenu' => 'required|exists:type_contenus,id',
            'id_region' => 'required|exists:regions,id',
            'id_langue' => 'required|exists:langues,id',
            'id_auteur' => 'required|exists:utilisateurs,id',
            'type_acces' => 'required|in:gratuit,payant',
            'prix' => 'nullable|required_if:type_acces,payant|numeric|min:0',
        ]);

        // Si gratuit, on force le prix à null
        if ($validated['type_acces'] === 'gratuit') {
            $validated['prix'] = null;
        }

        $validated['slug'] = \Str::slug($validated['titre']);

        $contenu->update($validated);

        return redirect()->route('admin.contenus.index')->with('success', 'Contenu mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $contenu = Contenus::findOrFail($id);
        $contenu->delete();
        return redirect()->route('admin.contenus.index')->with('success', 'Contenu supprimé avec succès.');
    }

    public function changerStatut(Request $request, $id)
    {
        $contenu = Contenus::findOrFail($id);
        $nouv_statut = $request->input('statut');

        if (!in_array($nouv_statut, ['publié', 'rejeté', 'en_attente', 'brouillon'])) {
            return back()->with('error', 'Statut invalide.');
        }

        $contenu->statut = $nouv_statut;
        
        if ($nouv_statut === 'publié') {
            $contenu->published_at = now();
            // TODO: Assigner le modérateur connecté
            // $contenu->id_moderateur = auth()->id();
        }

        $contenu->save();

        return back()->with('success', 'Statut du contenu mis à jour : ' . $nouv_statut);
    }
}
