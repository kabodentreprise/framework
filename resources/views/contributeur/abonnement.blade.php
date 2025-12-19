@extends('Layout')

@section('title', 'Abonnement Contributeur')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-success text-white text-center py-4">
                    <h2 class="mb-0"><i class="bi bi-person-workspace me-2"></i>Devenir Contributeur</h2>
                </div>
                <div class="card-body p-5">
                    @if(session('info'))
                        <div class="alert alert-info">
                            {{ session('info') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="text-center mb-5">
                        <img src="{{ asset('adminlte/img/illustration-writer.png') }}" alt="Contributeur" class="img-fluid mb-3" style="max-height: 200px; opacity: 0.8">
                        <h4 class="fw-bold">Pourquoi devenir contributeur ?</h4>
                        <p class="text-muted">Rejoignez notre communauté d'auteurs et partagez votre passion pour la culture.</p>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="icon-square bg-light text-success flex-shrink-0 me-3">
                                    <i class="bi bi-pencil-square fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Publiez vos contenus</h5>
                                    <p class="mb-0">Articles, vidéos, musiques... Partagez vos œuvres avec le monde entier.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="icon-square bg-light text-success flex-shrink-0 me-3">
                                    <i class="bi bi-cash-coin fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold">Gagnez des revenus</h5>
                                    <p class="mb-0">Recevez une commission sur chaque vente de vos contenus payants.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <h3 class="mb-3">Frais d'adhésion unique</h3>
                        <div class="display-4 fw-bold text-primary mb-2">5 000 FCFA</div>
                        <p class="text-muted mb-4">Accès à vie à l'espace contributeur</p>

                        <form action="{{ route('contributeur.paiement.initier') }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg px-5 py-3 rounded-pill shadow w-100">
                                <i class="bi bi-credit-card me-2"></i>Payer maintenant
                            </button>
                        </form>
                        <p class="small text-muted mt-3"><i class="bi bi-lock-fill me-1"></i>Paiement sécurisé via FedaPay</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
