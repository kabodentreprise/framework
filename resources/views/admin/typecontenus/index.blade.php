{{-- Vue index pour les types de contenus --}}
@extends('layouts.admin')

@section('titre')
<h1>Types de Contenus</h1>
@endsection

@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Liste des types de contenus</h3>
    <a href="{{ url('/typecontenues/create') }}" class="btn btn-primary float-end">Nouveau</a>
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Nom</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Exemple de données statiques -->
        <tr>
          <td>1</td>
          <td>Article</td>
          <td>Contenu textuel</td>
          <td>
            <a href="{{ url('/typecontenues/1/edit') }}" class="btn btn-warning btn-sm">Modifier</a>
            <a href="{{ url('/typecontenues/1') }}" class="btn btn-danger btn-sm">Supprimer</a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="card-footer">
    <a href="{{ url('/typecontenues') }}" class="btn btn-secondary">Annuler</a>
    <button class="btn btn-success float-end">Enregistrer</button>
  </div>
</div>
@endsection
