@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')
@section('page-title', 'Gestion des Utilisateurs')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Liste des utilisateurs</h3>
            <a href="{{ route('admin.utilisateurs.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nouvel Utilisateur
            </a>
        </div>

        <div class="p-5">
            <table id="utilisateursTable" class="min-w-full divide-y divide-gray-200" style="width:100%">
                <thead class="bg-orange-600 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nom complet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Sexe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Rôle</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date d'inscription</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- DataTables will populate this -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- DataTables CSS & JS -->
    @push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.tailwindcss.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.tailwindcss.min.js"></script>
    <!-- French translation -->
    <script src="https://cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json"></script>

    <script>
        $(document).ready(function() {
            $('#utilisateursTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.utilisateurs.api') }}",
                    error: function (xhr, error, thrown) {
                        console.log("Error:", xhr, error, thrown);
                        alert("Erreur de chargement des données. Veuillez vérifier la console.");
                    }
                },
                columns: [
                    { data: 'nom_complet', name: 'nom' }, // Using 'nom' for sorting logic in controller if needed
                    { data: 'email', name: 'email' },
                    { data: 'sexe', name: 'sexe', orderable: false },
                    { data: 'role', name: 'role.nom_role' },
                    { data: 'statut', name: 'statut' },
                    { data: 'date_inscription', name: 'date_inscription' },
                    { data: 'actions', name: 'actions', orderable: false, searchable: false, className: 'text-right' }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/fr-FR.json"
                },
                dom: '<"flex flex-col md:flex-row justify-between items-center mb-4"lf>rt<"flex flex-col md:flex-row justify-between items-center mt-4"ip>',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Tout"]]
            });
        });
    </script>
    <style>
        /* Custom Tailwind overrides for DataTables */
        .dataTables_wrapper select {
            padding-right: 2rem !important;
            border-radius: 0.5rem;
            border-color: #d1d5db;
        }
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.5rem;
            border-color: #d1d5db;
            padding: 0.5rem 1rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #ea580c !important; /* Orange-600 */
            color: white !important;
            border: 1px solid #ea580c !important;
            border-radius: 0.375rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #fed7aa !important; /* Orange-200 */
            color: #ea580c !important;
            border: 1px solid #fdba74 !important;
            border-radius: 0.375rem;
        }
    </style>
    @endpush
@endsection
