@extends('layouts.admin')

@section('title', 'Historique des Paiements')
@section('page-title', 'Historique des Paiements')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-xl font-bold text-gray-800">Liste des Transactions</h2>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
            <p class="font-bold">Succès</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
            <p class="font-bold">Erreur</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table id="paiementsTable" class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-white uppercase bg-orange-600">
                <tr>
                    <th scope="col" class="px-6 py-3 rounded-tl-lg">ID</th>
                    <th scope="col" class="px-6 py-3">Référence</th>
                    <th scope="col" class="px-6 py-3">Contenu</th>
                    <th scope="col" class="px-6 py-3">Utilisateur</th>
                    <th scope="col" class="px-6 py-3">Montant</th>
                    <th scope="col" class="px-6 py-3">Statut</th>
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3 text-right rounded-tr-lg">Actions</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<style>
    /* Custom Tailwind-like styling for DataTables */
    .dataTables_wrapper .dataTables_length select {
        padding-right: 2rem;
        background-color: #fff;
        border-color: #d1d5db;
        border-radius: 0.375rem;
    }
    .dataTables_wrapper .dataTables_filter input {
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        margin-left: 0.5rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #ea580c !important; /* Orange-600 */
        color: white !important;
        border: 1px solid #ea580c !important;
        border-radius: 0.375rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #fb923c !important; /* Orange-400 */
        color: white !important;
        border: 1px solid #fb923c !important;
    }
</style>

<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    $('#paiementsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.paiements.api') }}",
            error: function (xhr, error, thrown) {
                console.log("Error:", xhr, error, thrown);
                alert("Erreur de chargement des données.");
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'reference', name: 'reference' },
            { data: 'id_contenu', name: 'id_contenu' }, // handled by API editColumn
            { data: 'id_utilisateur', name: 'id_utilisateur' }, // handled by API editColumn
            { data: 'montant', name: 'montant' },
            { data: 'statut', name: 'statut' },
            { data: 'date_achat', name: 'date_achat' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-right' }
        ],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json"
        },
        dom: '<"flex flex-col md:flex-row justify-between items-center mb-4"lf>rt<"flex flex-col md:flex-row justify-between items-center mt-4"ip>',
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tout"]],
        order: [[0, 'desc']] // Tri par ID décroissant par défaut
    });
});
</script>
@endsection
