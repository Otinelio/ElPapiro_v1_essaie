@extends('layouts.user')

@section('titre')
Détails de la commande #{{ $commande->id }} | El-Papiro
@endsection

@section('commandes')
active
@endsection

@section("beta")
{{     $totalProduitPanier > 0 ? 'badge' :  ""     }}
@endsection

@section('alpha')
{{     $totalProduitPanier > 0 ? $totalProduitPanier :  null     }}
@endsection

@section('main')
<main>
    {{-- Section Bannière --}}
    <section id="boutique1" class="mb-4">
        <div class="banner">
            <div class="banner-over pt-lg-3 pb-lg-2 px-lg-0 px-2">
                <div class="banner-texte container pt-5 my-5">
                    <div class="row">
                        <h1 class="text-center fw-bold">Détails de la commande #{{ $commande->id }}</h1>
                        <p class="fs-4">
                            <a href="{{ route('user.index') }}" style="color: var(--color-jaune);">Accueil</a>
                            <span style="color: #3d3838;">/</span>
                            <a href="{{ route('user.commandes.index') }}" style="color: var(--color-jaune);">Commandes</a>
                            <span style="color: #3d3838;">/</span>
                            <span>Détails</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                {{-- Informations de la commande --}}
                <div class="col-lg-8">
                    {{-- Statut de la commande --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-0">Statut de la commande</h5>
                                    <p class="text-muted mb-0">
                                        Commandé le {{ $commande->created_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>
                                <div>
                                    @switch($commande->status)
                                        @case('pending')
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-clock me-1"></i>En attente
                                            </span>
                                            @break
                                        @case('pay-on-delivery')
                                            <span class="badge bg-info">
                                                <i class="bi bi-truck me-1"></i>Paiement à la livraison
                                            </span>
                                            @break
                                        @case('pickup')
                                            <span class="badge bg-primary">
                                                <i class="bi bi-shop me-1"></i>À retirer en boutique
                                            </span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle me-1"></i>Terminée
                                            </span>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Produits commandés --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-cart-fill me-2"></i>
                                Produits commandés
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Produit</th>
                                            <th>Prix unitaire</th>
                                            <th>Quantité</th>
                                            <th class="text-end pe-4">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($items as $item)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('assets/produits/' . $item->produit->image) }}" 
                                                             alt="{{ $item->produit->name }}"
                                                             class="img-thumbnail me-3"
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                        <div>
                                                            <h6 class="mb-0">{{ $item->produit->name }}</h6>
                                                            <small class="text-muted">{{ $item->produit->categorie->name }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ number_format($item->prix, 0, ',', ' ') }} FCFA</td>
                                                <td>{{ $item->quantite }}</td>
                                                <td class="text-end pe-4">{{ number_format($item->prix * $item->quantite, 0, ',', ' ') }} FCFA</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Résumé et informations client --}}
                <div class="col-lg-4">
                    {{-- Résumé de la commande --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-receipt me-2"></i>
                                Résumé de la commande
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Total produits</span>
                                <span>{{ $items->sum('quantite') }} article(s)</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Mode de paiement</span>
                                <span>
                                    @switch($commande->mode_paiement)
                                        @case('delivery')
                                            <i class="bi bi-cash me-1"></i>À la livraison
                                            @break
                                        @case('pickup')
                                            <i class="bi bi-shop me-1"></i>En boutique
                                            @break
                                        @case('cinetpay')
                                            <i class="bi bi-credit-card me-1"></i>En ligne
                                            @break
                                    @endswitch
                                </span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0">Total</h5>
                                <h5 class="mb-0" style="color: #C70039;">
                                    {{ number_format($total, 0, ',', ' ') }} FCFA
                                </h5>
                            </div>
                        </div>
                    </div>

                    {{-- Informations client --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h5 class="card-title mb-0">
                                <i class="bi bi-person-fill me-2"></i>
                                Informations client
                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Nom :</strong><br>
                                {{ $commande->client_name }}
                            </p>
                            <p class="mb-2">
                                <strong>Email :</strong><br>
                                {{ $commande->client_email }}
                            </p>
                            <p class="mb-2">
                                <strong>Téléphone :</strong><br>
                                {{ $commande->client_phone }}
                            </p>
                            <p class="mb-2">
                                <strong>Adresse :</strong><br>
                                {{ $commande->adresse }}
                            </p>
                            <p class="mb-2">
                                <strong>Ville :</strong><br>
                                {{ $commande->ville }}
                            </p>
                            <p class="mb-2">
                                <strong>Pays :</strong><br>
                                {{ $commande->pays }}
                            </p>
                            @if($commande->code_postal)
                                <p class="mb-0">
                                    <strong>Code postal :</strong><br>
                                    {{ $commande->code_postal }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Boutons d'action --}}
            <div class="text-center mt-4">
                <a href="{{ route('user.commandes.index') }}" class="btn btn-outline-primary me-2">
                    <i class="bi bi-arrow-left me-2"></i>
                    Retour aux commandes
                </a>
                <a href="{{ route('user.boutique') }}" class="animated-button">
                    <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                    </svg>
                    <span class="text">Continuer mes achats</span>
                    <span class="circle"></span>
                    <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>
</main>

<style>
/* Styles pour les badges */
.badge {
    padding: 8px 12px;
    font-weight: 500;
}

/* Styles pour les cartes */
.card {
    border-radius: 10px;
    overflow: hidden;
}

.card-header {
    border-bottom: 1px solid #eee;
}

/* Style pour la table */
.table > :not(caption) > * > * {
    padding: 1rem;
}

/* Style pour les boutons */
.btn-outline-primary {
    border-color: #C70039;
    color: #C70039;
}

.btn-outline-primary:hover {
    background-color: #C70039;
    border-color: #C70039;
    color: white;
}

/* Style pour le bouton animé */
.animated-button {
    position: relative;
    display: inline-block;
    padding: 12px 24px;
    border: none;
    background: #C70039;
    color: white;
    font-size: 1.1em;
    cursor: pointer;
    border-radius: 25px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.animated-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(199, 0, 57, 0.3);
}

.animated-button .circle {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    transform: scale(0);
    transition: transform 0.3s ease;
}

.animated-button:hover .circle {
    transform: scale(3);
}

/* Animation des badges */
.badge i {
    animation: fadeInOut 2s infinite;
}

@keyframes fadeInOut {
    0% { opacity: 0.5; }
    50% { opacity: 1; }
    100% { opacity: 0.5; }
}
</style>
@endsection