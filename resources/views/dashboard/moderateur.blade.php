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

    <!-- Message de bienvenue -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Bienvenue dans l'espace modération</h5>
                </div>
                <div class="card-body">
                    <p>En tant que modérateur, vous êtes responsable de :</p>
                    <ul>
                        <li>✅ Valider les contenus soumis par les contributeurs</li>
                        <li>✅ Modérer les commentaires des utilisateurs</li>
                        <li>✅ Assurer la qualité des publications</li>
                        <li>✅ Respecter les guidelines culturelles</li>
                    </ul>
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.contenus.index') }}" class="btn btn-primary">
                            <i class="bi bi-journal-check"></i> Commencer la modération
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
