@extends('Layout')

@section('title', 'Dashboard Modérateur')

@section('titre')
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Dashboard Modérateur</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item active">Modération</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Statistiques Modérateur -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ $stats['content_pending'] ?? 0 }}</h3>
                    <p>Contenus en attente</p>
                </div>
                <i class="small-box-icon bi bi-clock-history"></i>
                <a href="{{ route('admin.contenus.index') }}" class="small-box-footer link-dark">
                    Vérifier <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-info">
                <div class="inner">
                    <h3>{{ $stats['content_validated'] ?? 0 }}</h3>
                    <p>Contenus validés</p>
                </div>
                <i class="small-box-icon bi bi-check-circle"></i>
                <a href="{{ route('admin.contenus.index') }}" class="small-box-footer link-light">
                    Voir <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>{{ $stats['comments_pending'] ?? 0 }}</h3>
                    <p>Commentaires en attente</p>
                </div>
                <i class="small-box-icon bi bi-chat-dots"></i>
                <a href="{{ route('admin.commentaires.index') }}" class="small-box-footer link-light">
                    Modérer <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>{{ $stats['total_contributors'] ?? 0 }}</h3>
                    <p>Contributeurs actifs</p>
                </div>
                <i class="small-box-icon bi bi-people"></i>
                <a href="#" class="small-box-footer link-light">
                    Voir <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Liste des contenus en attente de validation -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title fw-bold text-primary mb-0">
                        <i class="bi bi-hourglass-split me-2"></i>Contenus en attente de validation
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Titre</th>
                                    <th>Auteur</th>
                                    <th>Date Smission</th>
                                    <th>Type</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contenus_attente as $contenu)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold">{{ $contenu->titre }}</div>
                                        <div class="small text-muted text-truncate" style="max-width: 300px;">
                                            {{ Str::limit(strip_tags($contenu->texte), 50) }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($contenu->auteur)
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2 bg-secondary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    {{ strtoupper(substr($contenu->auteur->prenom, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="small fw-bold">{{ $contenu->auteur->prenom }} {{ $contenu->auteur->nom }}</div>
                                                    <div class="small text-muted">Solde: {{ $contenu->auteur->solde }} F</div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Inconnu</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="small">{{ $contenu->created_at->format('d/m/Y H:i') }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25">
                                            {{ $contenu->typeContenu->nom_contenu ?? 'Autre' }}
                                        </span>
                                        @if($contenu->type_acces === 'payant')
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 ms-1">
                                                {{ $contenu->prix }} F
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('admin.contenus.show', $contenu->id) }}" class="btn btn-sm btn-outline-primary" title="Voir le contenu">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            
                                            <form action="{{ route('admin.contenus.changer-statut', $contenu->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment publier ce contenu ?');">
                                                @csrf
                                                <input type="hidden" name="statut" value="publié">
                                                <button type="submit" class="btn btn-sm btn-success" title="Valider et Publier">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.contenus.changer-statut', $contenu->id) }}" method="POST" onsubmit="return confirm('Voulez-vous rejeter ce contenu ?');">
                                                @csrf
                                                <input type="hidden" name="statut" value="rejeté">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Rejeter">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-check2-circle fs-1 d-block mb-3 text-success"></i>
                                        Aucun contenu en attente de validation.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white text-end">
                    <a href="{{ route('admin.contenus.index') }}" class="text-decoration-none small">
                        Voir tous les contenus <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
