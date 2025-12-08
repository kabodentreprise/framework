<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Regions;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegionsController extends Controller
{
    public function api(Request $request)
    {
        $query = Regions::select(['id', 'nom_region', 'description', 'population', 'superficie', 'localisation', 'created_at', 'updated_at']);

        if ($request->has('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('nom_region', 'like', "%{$searchValue}%")
                  ->orWhere('description', 'like', "%{$searchValue}%")
                  ->orWhere('localisation', 'like', "%{$searchValue}%");
            });
        }

        if ($request->has('order')) {
            $columns = ['nom_region', 'description', 'population', 'superficie', 'localisation'];
            $columnIndex = $request->order[0]['column'];
            $columnName = $columns[$columnIndex] ?? 'id';
            $direction = $request->order[0]['dir'];
            $query->orderBy($columnName, $direction);
        } else {
            $query->orderBy('nom_region', 'asc');
        }

        $total = $query->count();
        $regions = $query->skip($request->start)->take($request->length)->get();

        $data = $regions->map(function ($region) {
            return [
                'nom_region' => $region->nom_region,
                'description' => Str::limit($region->description, 50),
                'population' => number_format($region->population, 0, ',', ' '),
                'superficie' => number_format($region->superficie, 2, ',', ' '),
                'localisation' => $region->localisation,
                'actions' => view('partials.actions-region', compact('region'))->render()
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
        return view('admin.regions.index');
    }

    public function create()
    {
        return view('admin.regions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_region' => 'required|string|max:255|unique:regions,nom_region',
            'description' => 'nullable|string',
            'population' => 'nullable|integer',
            'superficie' => 'nullable|numeric',
            'localisation' => 'nullable|string'
        ]);

        Regions::create($validated);
        return redirect()->route('admin.regions.index')->with('success', 'Région créée avec succès.');
    }

    public function show(Regions $region)
    {
        return view('admin.regions.show', compact('region'));
    }

    public function edit(Regions $region)
    {
        return view('admin.regions.edit', compact('region'));
    }

    public function update(Request $request, Regions $region)
    {
        $validated = $request->validate([
            'nom_region' => 'required|string|max:255|unique:regions,nom_region,' . $region->id,
            'description' => 'nullable|string',
            'population' => 'nullable|integer',
            'superficie' => 'nullable|numeric',
            'localisation' => 'nullable|string'
        ]);

        $region->update($validated);
        return redirect()->route('admin.regions.index')->with('success', 'Région mise à jour avec succès.');
    }

    public function destroy(Regions $region)
    {
        $region->delete();
        return redirect()->route('admin.regions.index')->with('success', 'Région supprimée avec succès.');
    }
}
