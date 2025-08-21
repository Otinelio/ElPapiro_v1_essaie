@extends('layouts.user')

@section('titre')
Check-Out | El-Papiro
@endsection

@section("checkout")
active
@endsection



@section('main')

@if(session('whatsappLink'))
        <div class="text-center mt-4">
            <a href="{{ session('whatsappLink') }}" class="btn btn-success btn-lg" target="_blank">
                <i class="fab fa-whatsapp me-2"></i>
                Recevoir le récapitulatif sur WhatsApp
            </a>
        </div>
    @endif
<main>
    {{-- Section Bannière --}}
    <section id="boutique1" class="mb-4">
        <div class="banner">
      <div class="banner-over pt-lg-3 pb-lg-2 px-lg-0 px-2">
        <div class="banner-texte container pt-5 my-5">
          <div class="row">
                        <h1 class="text-center fw-bold">Résumé de votre commande</h1>
            <p class="fs-4">
                <a href="{{ route('user.index') }}" style="color: var(--color-jaune);">Accueil</a>
                <span style="color: #3d3838;">/</span>
                            <span>Confirmation</span>
            </p>
          </div>
        </div>
      </div>
    </div>
</section>

    <div class="container mb-4">
        <a href="{{ route('user.commandes.index') }}" class="btn-return">
            <i class="bi bi-arrow-left"></i>
            Retour
        </a>
    </div>

    <section class="py-4">
<div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert"
                     style="border-left: 5px solid #198754; background-color: #d1e7dd;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-4 me-2"></i>
                        <strong>{{ session('success') }}</strong>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
            @endif

            <div class="row">
                <div class="col-lg-8 mb-4">
                    {{-- Carte des informations de commande --}}
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-primary text-white py-3">
                            <h3 class="card-title mb-0 fs-4">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                Détails de la commande #{{ $commande->id }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                {{-- Informations client --}}
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <h4 class="fs-5 mb-3" style="color: #C70039;">
                                            <i class="bi bi-person-fill me-2"></i>Informations client
                                        </h4>
                                        <div class="ms-4">
                                            <p class="mb-2"><strong>Nom :</strong> {{ $commande->nom_client }}</p>
                                            <p class="mb-2"><strong>Email :</strong> {{ $commande->email_client }}</p>
                                            <p class="mb-2"><strong>Téléphone :</strong> {{ $commande->telephone_client }}</p>
                                        </div>
                                    </div>
                                </div>
                                {{-- Adresse de livraison --}}
                                <div class="col-md-6">
                                    <div class="p-3 bg-light rounded-3">
                                        <h4 class="fs-5 mb-3" style="color: #C70039;">
                                            <i class="bi bi-geo-alt-fill me-2"></i>Adresse
                                        </h4>
                                        <div class="ms-4">
                                            <p class="mb-2"><strong>Adresse :</strong> {{ $commande->adresse }}</p>
                                            <p class="mb-2"><strong>Ville :</strong> {{ $commande->ville }}</p>
                                            <p class="mb-2"><strong>Pays :</strong> {{ $commande->pays }}</p>
                                            @if($commande->code_postal)
                                                <p class="mb-2"><strong>Code postal :</strong> {{ $commande->code_postal }}</p>
            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
        </div>
    </div>

                    {{-- Carte des produits --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-warning text-dark py-3">
                            <h4 class="card-title mb-0 fs-4">
                                <i class="bi bi-cart-fill me-2"></i>
                                Produits commandés
                            </h4>
        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
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
                                                        <span>{{ $item->produit->name }}</span>
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

                {{-- Résumé de la commande --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-dark text-white py-3">
                            <h4 class="card-title mb-0 fs-4">
                                <i class="bi bi-receipt me-2"></i>
                                Résumé
                            </h4>
        </div>
        <div class="card-body">
                            {{-- Ajout du message de confirmation email --}}
                            <div class="alert alert-info mb-4" style="background-color: #e8f4f8; border-left: 4px solid #0dcaf0;">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-envelope-check-fill me-2 fs-4" style="color: #0dcaf0;"></i>
                                    <div>
                                        <strong>Email de confirmation envoyé !</strong>
                                        <p class="mb-0">Un récapitulatif de votre commande a été envoyé à <strong>{{ $commande->email_client }}</strong></p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mb-3">
                                <span>Date de commande</span>
                                <strong>{{ $commande->created_at->format('d/m/Y H:i') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Mode de paiement</span>
                                <strong>
                <span class="badge bg-info">
                    {{ $paymentMethods[$commande->mode_paiement] ?? ucfirst($commande->mode_paiement) }}
                </span>
                                </strong>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Statut</span>
                                <strong>
                                    @php
                                        $statut = $commande->statut ?? $commande->status ?? '-';
                                        $labels = [
                                            'en_attente' => 'En attente',
                                            'terminee' => 'Terminée',
                                            'annulee' => 'Annulée'
                                        ];
                                        $colors = [
                                            'en_attente' => 'warning',
                                            'terminee' => 'success',
                                            'annulee' => 'danger'
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $colors[$statut] ?? 'secondary' }}">
                                        {{ $labels[$statut] ?? ucfirst(str_replace('_', ' ', $statut)) }}
                                    </span>
                                </strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Total produits</span>
                                <strong>{{ $totalProduitPanier }} article(s)</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h4 class="mb-0">Total</h4>
                                <h4 class="mb-0" style="color: #C70039;">{{ number_format($total, 0, ',', ' ') }} FCFA</h4>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">


                        {{-- Bouton pour continuer les achats --}}
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
                    @if(isset($url))
    <div class="text-center mt-4">
        <a href="{{ $url }}" class="btn btn-success btn-lg" target="_blank">
            <i class="fab fa-whatsapp me-2"></i>
            Recevoir le récapitulatif sur WhatsApp
        </a>
    </div>
@endif
        </div>
    </div>
</div>
    </section>
</main>

<style>
    .btn-outline-primary {
    border: 2px solid #C70039;
    color: #C70039;
    padding: 12px 24px;
    border-radius: 25px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background-color: #C70039;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(199, 0, 57, 0.2);
}

.btn-outline-primary:active {
    transform: translateY(0);
}
/* Styles pour les badges */
.badge {
    padding: 8px 12px;
    font-weight: 500;
    font-size: 0.9rem;
}

/* Styles pour les cartes */
.card {
    border-radius: 10px;
    overflow: hidden;
}

.card-header {
    border-bottom: none;
}

/* Style pour la table */
.table > :not(caption) > * > * {
    padding: 1rem;
}

/* Animation pour le message de succès */
.alert-success {
    animation: slideIn 0.5s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateY(-100%);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
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
    width: 250px;
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

.animated-button .text {
    position: relative;
    z-index: 1;
    color: white;
    font-weight: 500;
}

.animated-button svg {
    width: 20px;
    height: 20px;
    fill: white;
    margin-right: 8px;
    transition: transform 0.3s ease;
}

.animated-button .arr-1 {
    position: absolute;
    right: 15px;
    opacity: 0;
    transform: translateX(-10px);
}

.animated-button .arr-2 {
    position: relative;
    margin-right: 8px;
    transform: translateX(0);
}

.animated-button:hover .arr-1 {
    opacity: 1;
    transform: translateX(0);
}

.animated-button:hover .arr-2 {
    opacity: 0;
    transform: translateX(10px);
}

/* Animation au survol */
.animated-button:hover {
    background: #a30030;
}

/* Style pour le focus */
.animated-button:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(199, 0, 57, 0.3);
}

/* Style pour le clic */
.animated-button:active {
    transform: translateY(0);
    box-shadow: 0 2px 8px rgba(199, 0, 57, 0.3);
}
</style>
@endsection
