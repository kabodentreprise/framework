@php
    $canEdit = $contenu->peutEtreModifie();
    $canDelete = $contenu->peutEtreSupprime();
@endphp

<div class="action-buttons">
    <!-- Vue -->
    <a href="{{ route('contenus.show', $contenu->id) }}"
       class="btn btn-primary btn-sm"
       title="Voir les détails"
       data-bs-toggle="tooltip">
        <i class="bi bi-eye"></i>
    </a>

    <!-- Édition -->
    @if($canEdit)
    <a href="{{ route('contenus.edit', $contenu->id) }}"
       class="btn btn-warning btn-sm"
       title="Modifier"
       data-bs-toggle="tooltip">
        <i class="bi bi-pencil"></i>
    </a>
    @else
    <button class="btn btn-warning btn-sm"
            title="Ce contenu ne peut pas être modifié"
            data-bs-toggle="tooltip"
            disabled>
        <i class="bi bi-pencil"></i>
    </button>
    @endif

    <!-- Actions rapides de statut -->
    <div class="dropdown">
        <button class="btn btn-info btn-sm dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                title="Changer le statut">
            <i class="bi bi-arrow-repeat"></i>
        </button>
        <ul class="dropdown-menu">
            @if($contenu->statut !== 'publié')
            <li>
                <a class="dropdown-item change-status"
                   href="#"
                   data-id="{{ $contenu->id }}"
                   data-status="publié">
                    <i class="bi bi-check-circle text-success me-2"></i> Publier
                </a>
            </li>
            @endif
            @if($contenu->statut !== 'en_attente')
            <li>
                <a class="dropdown-item change-status"
                   href="#"
                   data-id="{{ $contenu->id }}"
                   data-status="en_attente">
                    <i class="bi bi-clock text-warning me-2"></i> Mettre en attente
                </a>
            </li>
            @endif
            @if($contenu->statut !== 'rejeté')
            <li>
                <a class="dropdown-item change-status"
                   href="#"
                   data-id="{{ $contenu->id }}"
                   data-status="rejeté">
                    <i class="bi bi-x-circle text-danger me-2"></i> Rejeter
                </a>
            </li>
            @endif
            @if($contenu->statut !== 'brouillon')
            <li>
                <a class="dropdown-item change-status"
                   href="#"
                   data-id="{{ $contenu->id }}"
                   data-status="brouillon">
                    <i class="bi bi-file-earmark text-secondary me-2"></i> Mettre en brouillon
                </a>
            </li>
            @endif
        </ul>
    </div>

    <!-- Suppression -->
    @if($canDelete)
    <form action="{{ route('contenus.destroy', $contenu->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="button"
                class="btn btn-danger btn-sm btn-delete"
                title="Supprimer"
                data-bs-toggle="tooltip"
                data-title="{{ $contenu->titre }}">
            <i class="bi bi-trash"></i>
        </button>
    </form>
    @else
    <button class="btn btn-danger btn-sm"
            title="Ce contenu ne peut pas être supprimé"
            data-bs-toggle="tooltip"
            disabled>
        <i class="bi bi-trash"></i>
    </button>
    @endif
</div>

<!-- Script pour les changements de statut -->
<script>
$(document).ready(function() {
    $('.change-status').on('click', function(e) {
        e.preventDefault();

        var contenusId = $(this).data('id');
        var nouveauStatut = $(this).data('status');
        var button = $(this);

        Swal.fire({
            title: 'Changer le statut ?',
            text: "Voulez-vous vraiment changer le statut de ce contenu ?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, changer',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('contenus') }}/" + contenusId + "/changer-statut",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        statut: nouveauStatut
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire(
                                'Succès !',
                                'Le statut a été mis à jour avec succès.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Erreur !',
                            xhr.responseJSON?.error || 'Une erreur est survenue.',
                            'error'
                        );
                    }
                });
            }
        });
    });
});
</script>
