<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Langues;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LanguesController extends Controller
{
    public function api(Request $request)
    {
        $query = Langues::select(['id', 'nom_langue', 'code_langue', 'description']);

        if ($request->has('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('nom_langue', 'like', "%{$searchValue}%")
                  ->orWhere('code_langue', 'like', "%{$searchValue}%")
                  ->orWhere('description', 'like', "%{$searchValue}%");
            });
        }

        if ($request->has('order')) {
            $columns = ['code_langue', 'nom_langue', 'description'];
            $columnIndex = $request->order[0]['column'];
            $columnName = $columns[$columnIndex] ?? 'id';
            $direction = $request->order[0]['dir'];
            $query->orderBy($columnName, $direction);
        } else {
            $query->orderBy('nom_langue', 'asc');
        }

        $total = $query->count();
        $langues = $query->skip($request->start)->take($request->length)->get();

        $data = $langues->map(function ($langue) {
            return [
                'code_langue' => $langue->code_langue,
                'nom_langue' => $langue->nom_langue,
                'description' => Str::limit($langue->description, 50),
                'actions' => view('partials.actions-langue', compact('langue'))->render()
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
        return view('admin.langues.index');
    }

    public function create()
    {
        return view('admin.langues.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_langue' => 'required|string|max:255',
            'code_langue' => 'required|string|max:10|unique:langues,code_langue',
            'description' => 'nullable|string'
        ]);

        Langues::create($validated);
        return redirect()->route('admin.langues.index')->with('success', 'Langue créée avec succès.');
    }

    public function show(Langues $langue)
    {
        return view('admin.langues.show', compact('langue'));
    }

    public function edit(Langues $langue)
    {
        return view('admin.langues.edit', compact('langue'));
    }

    public function update(Request $request, Langues $langue)
    {
        $validated = $request->validate([
            'nom_langue' => 'required|string|max:255',
            'code_langue' => 'required|string|max:10|unique:langues,code_langue,' . $langue->id,
            'description' => 'nullable|string'
        ]);

        $langue->update($validated);
        return redirect()->route('admin.langues.index')->with('success', 'Langue mise à jour avec succès.');
    }

    public function destroy(Langues $langue)
    {
        $langue->delete();
        return redirect()->route('admin.langues.index')->with('success', 'Langue supprimée avec succès.');
    }
}
