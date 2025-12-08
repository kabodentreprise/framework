<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commentaires;
use App\Models\Utilisateurs;
use App\Models\Contenus;
use Illuminate\Http\Request;

class CommentairesController extends Controller
{
    public function api(Request $request)
    {
        $query = Commentaires::with(['utilisateur', 'contenu'])->select('commentaires.*');

        return datatables()->of($query)
            ->addColumn('actions', function ($item) {
                return view('partials.actions-commentaire', compact('item'))->render();
            })
            ->editColumn('texte', function ($item) {
                return \Str::limit($item->texte, 50);
            })
            ->editColumn('utilisateur', function ($item) {
                return $item->utilisateur ? $item->utilisateur->getFullName() : 'Anonyme';
            })
            ->editColumn('contenu', function ($item) {
                return $item->contenu ? \Str::limit($item->contenu->titre, 30) : 'Supprimé';
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at ? $item->created_at->format('d/m/Y H:i') : '-';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function index()
    {
        return view('admin.commentaires.index');
    }

    public function create()
    {
        $utilisateurs = \App\Models\Utilisateurs::all();
        $contenus = \App\Models\Contenus::select('id', 'titre')->get();
        return view('admin.commentaires.create', compact('utilisateurs', 'contenus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'texte' => 'required|string',
            'note' => 'nullable|integer|min:0|max:5',
            'date' => 'required|date',
            'id_utilisateur' => 'required|exists:utilisateurs,id',
            'id_contenu' => 'required|exists:contenus,id',
        ]);

        Commentaires::create($validated);

        return redirect()->route('admin.commentaires.index')->with('success', 'Commentaire ajouté avec succès.');
    }

    public function show($id)
    {
        $commentaire = Commentaires::with(['utilisateur', 'contenu'])->findOrFail($id);
        return view('admin.commentaires.show', compact('commentaire'));
    }

    public function edit($id)
    {
        $commentaire = Commentaires::findOrFail($id);
        $utilisateurs = \App\Models\Utilisateurs::all();
        $contenus = \App\Models\Contenus::select('id', 'titre')->get();
        return view('admin.commentaires.edit', compact('commentaire', 'utilisateurs', 'contenus'));
    }

    public function update(Request $request, $id)
    {
        $commentaire = Commentaires::findOrFail($id);

        $validated = $request->validate([
            'texte' => 'required|string',
            'note' => 'nullable|integer|min:0|max:5',
            'date' => 'required|date',
            'id_utilisateur' => 'required|exists:utilisateurs,id',
            'id_contenu' => 'required|exists:contenus,id',
        ]);

        $commentaire->update($validated);

        return redirect()->route('admin.commentaires.index')->with('success', 'Commentaire mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $commentaire = Commentaires::findOrFail($id);
        $commentaire->delete();
        return redirect()->route('admin.commentaires.index')->with('success', 'Commentaire supprimé avec succès.');
    }
}
