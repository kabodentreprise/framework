<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medias;
use App\Models\TypeMedias;
use App\Models\Contenus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediasController extends Controller
{
    public function api(Request $request)
    {
        $query = Medias::with('typeMedia', 'contenu')->select(['medias.*']);

        if ($request->has('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('chemin', 'like', "%{$searchValue}%")
                  ->orWhere('description', 'like', "%{$searchValue}%");
            });
        }

        if ($request->has('order')) {
            $columns = ['id', 'chemin', 'id_type_media', 'created_at'];
            $columnIndex = $request->order[0]['column'];
            $columnName = $columns[$columnIndex] ?? 'id';
            $direction = $request->order[0]['dir'];
            $query->orderBy($columnName, $direction);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $total = $query->count();
        $items = $query->skip($request->start)->take($request->length)->get();

        $data = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'chemin' => $item->chemin, // URL ou nom fichier
                'type_media' => $item->typeMedia ? $item->typeMedia->nom_media : 'N/A',
                'contenu' => $item->contenu ? $item->contenu->titre : 'Aucun',
                'created_at' => $item->created_at ? $item->created_at->format('d/m/Y') : 'N/A',
                'actions' => view('partials.actions-media', compact('item'))->render()
            ];
        });

        return response()->json([
            'draw' => $request->draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data
        ]);
    }

    public function index()
    {
        return view('admin.medias.index');
    }

    public function create()
    {
        $types = TypeMedias::all();
        $contenus = Contenus::all();
        return view('admin.medias.create', compact('types', 'contenus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:255',
            'id_type_media' => 'required|exists:type_medias,id',
            'id_contenu' => 'nullable|exists:contenus,id',
            'fichier' => 'required|file|max:10240' // Max 10MB
        ]);

        if ($request->hasFile('fichier')) {
            $path = $request->file('fichier')->store('uploads/medias', 'public');
            $validated['chemin'] = $path; // Stocker le chemin relatif
        }

        Medias::create($validated);
        return redirect()->route('admin.medias.index')->with('success', 'Média ajouté avec succès.');
    }

    public function show($id)
    {
        $media = Medias::with('typeMedia', 'contenu')->findOrFail($id);
        return view('admin.medias.show', compact('media'));
    }

    public function edit($id)
    {
        $media = Medias::findOrFail($id);
        $types = TypeMedias::all();
        $contenus = Contenus::all();
        return view('admin.medias.edit', compact('media', 'types', 'contenus'));
    }

    public function update(Request $request, $id)
    {
        $media = Medias::findOrFail($id);
        
        $validated = $request->validate([
            'description' => 'nullable|string|max:255',
            'id_type_media' => 'required|exists:type_medias,id',
            'id_contenu' => 'nullable|exists:contenus,id',
            'fichier' => 'nullable|file|max:10240'
        ]);

        if ($request->hasFile('fichier')) {
            // Supprimer l'ancien fichier si nécessaire
            if ($media->chemin && Storage::disk('public')->exists($media->chemin)) {
                Storage::disk('public')->delete($media->chemin);
            }
            $path = $request->file('fichier')->store('uploads/medias', 'public');
            $validated['chemin'] = $path;
        }

        $media->update($validated);
        return redirect()->route('admin.medias.index')->with('success', 'Média mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $media = Medias::findOrFail($id);
        if ($media->chemin && Storage::disk('public')->exists($media->chemin)) {
            Storage::disk('public')->delete($media->chemin);
        }
        $media->delete();
        return redirect()->route('admin.medias.index')->with('success', 'Média supprimé avec succès.');
    }
}
