@extends('Layout')

@section('title', 'Dashboard Contributeur')

@section('titre')
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Dashboard Contributeur</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item active">Contribution</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Statistiques Contributeur -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>{{ $stats['my_contents'] ?? 0 }}</h3>
                    <p>Mes contenus</p>
                </div>
                <i class="small-box-icon bi bi-journal"></i>
                <a href="{{ route('admin.contenus.index') }}" class="small-box-footer link-light">
                    Voir <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>{{ $stats['published_contents'] ?? 0 }}</h3>
                    <p>Contenus publiés</p>
                </div>
                <i class="small-box-icon bi bi-check-circle"></i>
                <a href="{{ route('admin.contenus.index') }}" class="small-box-footer link-light">
                    Voir <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>{{ $stats['pending_contents'] ?? 0 }}</h3>
                    <p>En attente</p>
                </div>
                <i class="small-box-icon bi bi-clock"></i>
                <a href="{{ route('admin.contenus.index') }}" class="small-box-footer link-dark">
                    Voir <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-info">
                <div class="inner">
                    <h3>{{ $stats['my_medias'] ?? 0 }}</h3>
                    <p>Médias ajoutés</p>
                </div>
                <i class="small-box-icon bi bi-images"></i>
                <a href="{{ route('admin.medias.index') }}" class="small-box-footer link-light">
                    Voir <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Actions rapides Contributeur -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Contribuer à la plateforme</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-journal-plus display-4 text-primary"></i>
                                    <h5>Nouveau contenu</h5>
                                    <p>Partagez une histoire, recette ou tradition</p>
                                    <a href="{{ route('admin.contenus.create') }}" class="btn btn-primary">
                                        Créer un contenu
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-camera display-4 text-success"></i>
                                    <h5>Ajouter un média</h5>
                                    <p>Photos, audios ou vidéos illustratifs</p>
                                    <a href="{{ route('admin.medias.create') }}" class="btn btn-success">
                                        Ajouter un média
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="bi bi-translate display-4 text-warning"></i>
                                    <h5>Traduire</h5>
                                    <p>Proposer des traductions dans d'autres langues</p>
                                    <a href="#" class="btn btn-warning">
                                        Proposer une traduction
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
