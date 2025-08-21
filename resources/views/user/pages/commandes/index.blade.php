@extends('layouts.user')

@section('titre')
Mes Commandes | El-Papiro
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
                        <h1 class="text-center fw-bold">Mes Commandes</h1>
                        <p class="fs-4">
                            <a href="{{ route('user.index') }}" style="color: var(--color-jaune);">Accueil</a>
                            <span style="color: #3d3838;">/</span>
                            <span>Commandes</span>
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

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h4 class="card-title mb-0" style="color: #C70039;">
                        <i class="bi bi-clock-history me-2"></i>
                        Historique des commandes
                    </h4>
                </div>
                <div class="card-body p-0">
                    @if($commandes->isEmpty())
                        <div class="text-center py-5">
                            <h3 class="fs-5 text-muted">Aucune commande trouvée</h3>
                            <p class="text-muted mb-4">Vous n'avez pas encore passé de commande</p>
                            <a href="{{ route('user.boutique') }}" class="animated-button">
                                Découvrir nos produits
                                <span class="text"></span>
                                <span class="circle"></span>
                            </a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">N° Commande</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Statut</th>
                                        <th>Mode de paiement</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commandes as $commande)
                                        <tr>
                                            <td class="ps-4 fw-bold">#{{ $commande->id }}</td>
                                            <td>{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ number_format($commande->total, 0, ',', ' ') }} FCFA</td>
                                            <td>
                                                @switch($commande->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="bi bi-clock me-1"></i>En attente
                                                        </span>
                                                        @break
                                                    @case('pay-on-delivery')
                                                        <span class="badge bg-info">
                                                            <i class="bi bi-truck me-1"></i>Livraison
                                                        </span>
                                                        @break
                                                    @case('pickup')
                                                        <span class="badge bg-primary">
                                                            <i class="bi bi-shop me-1"></i>À retirer
                                                        </span>
                                                        @break
                                                    @case('completed')
                                                        <span class="badge bg-success">
                                                            <i class="bi bi-check-circle me-1"></i>Terminée
                                                        </span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">
                                                            {{ $commande->status }}
                                                        </span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($commande->mode_paiement)
                                                    @case('delivery')
                                                        <i class="bi bi-cash me-1"></i>Paiement à la livraison
                                                        @break
                                                    @case('pickup')
                                                        <i class="bi bi-shop me-1"></i>Retrait en boutique
                                                        @break
                                                    @case('cinetpay')
                                                        <i class="bi bi-credit-card me-1"></i>Paiement en ligne
                                                        @break
                                                @endswitch
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="{{ route('user.commandes.show', $commande) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>
                                                    Voir détails
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Pagination --}}
            @if($commandes->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $commandes->links() }}
                </div>
            @endif
        </div>
    </section>
</main>

<style>
.badge {
    padding: 8px 12px;
    font-weight: 500;
}

.table > :not(caption) > * > * {
    padding: 1rem;
}

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