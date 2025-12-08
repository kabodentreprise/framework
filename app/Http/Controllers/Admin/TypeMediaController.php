<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeMedias;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TypeMediaController extends Controller
{
    public function api(Request $request)
    {
        $query = TypeMedias::select(['id', 'nom_media', 'created_at', 'updated_at']);

        if ($request->has('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('nom_media', 'like', "%{$searchValue}%");
            });
        }

        if ($request->has('order')) {
            $columns = ['id', 'nom_media', 'created_at'];
            $columnIndex = $request->order[0]['column'];
            $columnName = $columns[$columnIndex] ?? 'id';
            $direction = $request->order[0]['dir'];
            $query->orderBy($columnName, $direction);
        } else {
            $query->orderBy('nom_media', 'asc');
        }

        $total = $query->count();
        $items = $query->skip($request->start)->take($request->length)->get();

        $data = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'nom_media' => $item->nom_media,
                'created_at' => $item->created_at ? $item->created_at->format('d/m/Y') : 'N/A',
                'actions' => view('partials.actions-type-media', compact('item'))->render()
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
        return view('admin.typemedias.index');
    }

    public function create()
    {
        return view('admin.typemedias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_media' => 'required|string|max:255|unique:type_medias,nom_media'
        ]);

        TypeMedias::create($validated);
        return redirect()->route('admin.type-medias.index')->with('success', 'Type de média créé avec succès.');
    }

    public function show($id)
    {
        $typeMedia = TypeMedias::findOrFail($id);
        return view('admin.typemedias.show', compact('typeMedia'));
    }

    public function edit($id)
    {
        $typeMedia = TypeMedias::findOrFail($id);
        return view('admin.typemedias.edit', compact('typeMedia'));
    }

    public function update(Request $request, $id)
    {
        $typeMedia = TypeMedias::findOrFail($id);
        
        $validated = $request->validate([
            'nom_media' => 'required|string|max:255|unique:type_medias,nom_media,' . $typeMedia->id
        ]);

        $typeMedia->update($validated);
        return redirect()->route('admin.type-medias.index')->with('success', 'Type de média mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $typeMedia = TypeMedias::findOrFail($id);
        $typeMedia->delete();
        return redirect()->route('admin.type-medias.index')->with('success', 'Type de média supprimé avec succès.');
    }
}
