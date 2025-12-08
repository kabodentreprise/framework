<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RolesController extends Controller
{
    public function api(Request $request)
    {
        $query = Roles::select(['id', 'nom_role']);

        if ($request->has('search') && $request->search['value']) {
            $searchValue = $request->search['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('nom_role', 'like', "%{$searchValue}%");
            });
        }

        if ($request->has('order')) {
            $columns = ['id', 'nom_role']; // Adjust columns as needed
            $columnIndex = $request->order[0]['column'];
            $columnName = $columns[$columnIndex] ?? 'id';
            $direction = $request->order[0]['dir'];
            $query->orderBy($columnName, $direction);
        } else {
            $query->orderBy('nom_role', 'asc');
        }

        $total = $query->count();
        $roles = $query->skip($request->start)->take($request->length)->get();

        $data = $roles->map(function ($role) {
            return [
                'id' => $role->id,
                'nom_role' => $role->nom_role,
                'actions' => view('partials.actions-role', compact('role'))->render()
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
        return view('admin.roles.index');
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_role' => 'required|string|max:255|unique:roles,nom_role'
        ]);

        Roles::create($validated);
        return redirect()->route('admin.roles.index')->with('success', 'Rôle créé avec succès.');
    }

    public function show($id)
    {
        // Not often used for simple lookup tables, but kept for consistency
        $role = Roles::findOrFail($id);
        return view('admin.roles.show', compact('role'));
    }

    public function edit($id)
    {
        $role = Roles::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = Roles::findOrFail($id);
        
        $validated = $request->validate([
            'nom_role' => 'required|string|max:255|unique:roles,nom_role,' . $role->id
        ]);

        $role->update($validated);
        return redirect()->route('admin.roles.index')->with('success', 'Rôle mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $role = Roles::findOrFail($id);
        // Prevent deleting admin role if id 1 is reserved
        if ($role->id === 1) {
            return redirect()->route('admin.roles.index')->with('error', 'Impossible de supprimer le rôle Administrateur.');
        }
        
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Rôle supprimé avec succès.');
    }
}
