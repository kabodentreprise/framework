<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TypeContenus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TypeContenuController extends Controller
{
    public function api(Request $request)
    {
        $query = TypeContenus::select(['id', 'nom_contenu', 'created_at', 'updated_at']);

        if ($request->has('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('nom_contenu', 'like', "%{$searchValue}%");
            });
        }

        if ($request->has('order')) {
            $columns = ['id', 'nom_contenu', 'created_at'];
            $columnIndex = $request->order[0]['column'];
            $columnName = $columns[$columnIndex] ?? 'id';
            $direction = $request->order[0]['dir'];
            $query->orderBy($columnName, $direction);
        } else {
            $query->orderBy('nom_contenu', 'asc');
        }

        $total = $query->count();
        $items = $query->skip($request->start)->take($request->length)->get();

        $data = $items->map(function ($item) {
            return [
                'id' => $item->id,
                'nom_contenu' => $item->nom_contenu,
                'created_at' => $item->created_at ? $item->created_at->format('d/m/Y') : 'N/A',
                'actions' => view('partials.actions-type-contenu', compact('item'))->render()
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
        return view('admin.typecontenues.index');
    }

    public function create()
    {
        return view('admin.typecontenues.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_contenu' => 'required|string|max:255|unique:type_contenus,nom_contenu'
        ]);

        TypeContenus::create($validated);
        return redirect()->route('admin.typecontenus.index')->with('success', 'Type de contenu créé avec succès.');
    }

    public function show($id)
    {
        $typeContenu = TypeContenus::findOrFail($id);
        return view('admin.typecontenues.show', compact('typeContenu'));
    }

    public function edit($id)
    {
        $typeContenu = TypeContenus::findOrFail($id);
        return view('admin.typecontenues.edit', compact('typeContenu'));
    }

    public function update(Request $request, $id)
    {
        $typeContenu = TypeContenus::findOrFail($id);
        
        $validated = $request->validate([
            'nom_contenu' => 'required|string|max:255|unique:type_contenus,nom_contenu,' . $typeContenu->id
        ]);

        $typeContenu->update($validated);
        return redirect()->route('admin.typecontenus.index')->with('success', 'Type de contenu mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $typeContenu = TypeContenus::findOrFail($id);
        $typeContenu->delete();
        return redirect()->route('admin.typecontenus.index')->with('success', 'Type de contenu supprimé avec succès.');
    }
}
