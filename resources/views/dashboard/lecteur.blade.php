<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Lecteur - Culture Bénin</title>

    <!-- Styles Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            min-height: 100vh;
            position: fixed;
            width: 250px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .stat-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .welcome-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
        }

        .content-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="p-4">
            <h4 class="text-center mb-4">
                <i class="bi bi-globe-americas"></i> Culture Bénin
            </h4>

            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link active text-white">
                        <i class="bi bi-speedometer2 me-2"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link text-white">
                        <i class="bi bi-house me-2"></i> Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-journal-text me-2"></i> Explorer les contenus
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-geo-alt me-2"></i> Par régions
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white">
                        <i class="bi bi-translate me-2"></i> Par langues
                    </a>
                </li>
                <li class="nav-item mt-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link text-white bg-transparent border-0 w-100 text-start">
                            <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-primary">Tableau de Bord</h2>
            <div class="d-flex align-items-center">
                <span class="me-3 text-muted">Bonjour, <strong>{{ $stats['nom_complet'] }}</strong></span>
                <div class="dropdown">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Mon profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Section de bienvenue -->
        <div class="welcome-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3>Bienvenue sur Culture Bénin !</h3>
                    <p class="mb-0">Découvrez la richesse culturelle du Bénin à travers nos contenus.</p>
                </div>
                <div class="col-md-4 text-end">
                    <i class="bi bi-globe-americas display-4 opacity-75"></i>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-journal-text display-6 text-primary mb-3"></i>
                        <h4 class="text-primary">{{ $stats['total_contenus'] }}</h4>
                        <p class="text-muted mb-0">Contenus publiés</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-geo-alt display-6 text-success mb-3"></i>
                        <h4 class="text-success">{{ $stats['total_regions'] }}</h4>
                        <p class="text-muted mb-0">Régions</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-translate display-6 text-warning mb-3"></i>
                        <h4 class="text-warning">{{ $stats['total_langues'] }}</h4>
                        <p class="text-muted mb-0">Langues</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="card-body text-center">
                        <i class="bi bi-clock display-6 text-info mb-3"></i>
                        <h4 class="text-info">{{ $stats['contenus_recents'] }}</h4>
                        <p class="text-muted mb-0">Nouveaux contenus</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Informations personnelles -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-person me-2"></i>Mes informations
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Nom :</strong> {{ $stats['nom_complet'] }}</p>
                        <p><strong>Email :</strong> {{ $stats['email'] }}</p>
                        <p><strong>Langue :</strong> {{ $stats['langue'] }}</p>
                        <p><strong>Inscrit depuis :</strong> {{ $stats['date_inscription'] }}</p>
                        <p><strong>Sexe :</strong>
                            @if($stats['sexe'] == 'H')
                                Homme
                            @elseif($stats['sexe'] == 'F')
                                Femme
                            @else
                                {{ $stats['sexe'] }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contenus récents -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-clock-history me-2"></i>Contenus récents
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($contenus_recents as $contenu)
                                <div class="col-md-6 mb-3">
                                    <div class="card content-card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $contenu->titre }}</h6>
                                            <p class="card-text small text-muted">
                                                {{ Str::limit($contenu->texte, 100) }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="bi bi-translate"></i>
                                                    {{ $contenu->langue->nom_langue ?? 'Non spécifiée' }}
                                                </small>
                                                <small class="text-muted">
                                                    <i class="bi bi-person"></i>
                                                    {{ $contenu->auteur->prenom ?? 'Auteur' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <p class="text-muted text-center">Aucun contenu récent pour le moment.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-lightning me-2"></i>Explorer rapidement
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 mb-3">
                                <a href="#" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-journal-text display-6 d-block mb-2"></i>
                                    Tous les contenus
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="#" class="btn btn-outline-success w-100">
                                    <i class="bi bi-geo-alt display-6 d-block mb-2"></i>
                                    Par région
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="#" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-translate display-6 d-block mb-2"></i>
                                    Par langue
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="#" class="btn btn-outline-info w-100">
                                    <i class="bi bi-search display-6 d-block mb-2"></i>
                                    Rechercher
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
