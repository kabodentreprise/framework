@extends('layouts.admin')

@section('title', 'Gestion des Types de Contenu')
@section('page-title', 'Gestion des Types de Contenu')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-xl font-bold text-gray-800">Liste des Types de Contenu</h2>
        <a href="{{ route('admin.typecontenus.create') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 active:bg-orange-800 focus:outline-none focus:border-orange-900 focus:ring ring-orange-300 disabled:opacity-25 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Nouveau Type
        </a>
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
        <table id="typeContenusTable" class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-white uppercase bg-orange-600">
                <tr>
                    <th scope="col" class="px-6 py-3 rounded-tl-lg">ID</th>
                    <th scope="col" class="px-6 py-3">Nom</th>
                    <th scope="col" class="px-6 py-3">Date de création</th>
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
    $('#typeContenusTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.typecontenus.api') }}",
            error: function (xhr, error, thrown) {
                console.log("Error:", xhr, error, thrown);
                alert("Erreur de chargement des données.");
            }
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'nom_contenu', name: 'nom_contenu' },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-right' }
        ],
            language: {
                "sEmptyTable":     "Aucune donnée disponible dans le tableau",
                "sInfo":           "Affichage de l'élément _START_ à _END_ sur _TOTAL_ éléments",
                "sInfoEmpty":      "Affichage de l'élément 0 à 0 sur 0 élément",
                "sInfoFiltered":   "(filtré à partir de _MAX_ éléments au total)",
                "sInfoPostFix":    "",
                "sInfoThousands":  ",",
                "sLengthMenu":     "Afficher _MENU_ éléments",
                "sLoadingRecords": "Chargement...",
                "sProcessing":     "Traitement...",
                "sSearch":         "Rechercher :",
                "sZeroRecords":    "Aucun élément correspondant trouvé",
                "oPaginate": {
                    "sFirst":    "Premier",
                    "sLast":     "Dernier",
                    "sNext":     "Suivant",
                    "sPrevious": "Précédent"
                },
                "oAria": {
                    "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
                    "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                },
                "select": {
                        "rows": {
                            "_": "%d lignes sélectionnées",
                            "0": "Aucune ligne sélectionnée",
                            "1": "1 ligne sélectionnée"
                        }
                }
            },
        dom: '<"flex flex-col md:flex-row justify-between items-center mb-4"lf>rt<"flex flex-col md:flex-row justify-between items-center mt-4"ip>',
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tout"]]
    });
});
</script>
@endsection
