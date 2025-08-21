@extends('layouts.user')

@section('titre')
    Check-Out | El-Papiro
@endsection

@section('checkout')
    active
@endsection

@section('beta')
    {{ $totalProduitPanier > 0 ? 'badge' : '' }}
@endsection

@section('alpha')
    {{ $totalProduitPanier > 0 ? $totalProduitPanier : null }}
@endsection


@section('main')

    <main>

        {{-- Section Bannière (inchangée) --}}
        <section id="boutique1" class="mb-5 pb-5">
            <div class="banner ">
                <div class="banner-over pt-lg-3 pb-lg-2 px-lg-0 px-2">
                    <div class="banner-texte container pt-5 my-5">
                        <div class="row">
                            <h1 class="text-center fw-bold">Check-out</h1>
                            <p class="fs-4">
                                <a href="{{ route('user.index') }}" style="color: var(--color-jaune);">Accueil</a>
                                <span style="color: #3d3838;">/</span>
                                <span>Check-out</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="check-out" class="mb-5 pb-5">
            <div class="container">

                <!-- Afficher les erreurs générales et de validation -->
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                @if (session('info'))
                    <div class="alert alert-info">{{ session('info') }}</div>
                @endif
                {{-- Affiche TOUTES les erreurs en haut --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h5 class="alert-heading">Veuillez corriger les erreurs :</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <hr style="color: #C70039;">
                    <h1 class="fs-1 fw-bold" style="color: #C70039;">Finaliser la Commande . . .</h1>
                    <hr style="color: #C70039;">

                    {{-- Vérification si le panier existe et n'est pas vide --}}
                    @if ($items && !empty($items))
                        {{-- Le formulaire englobe maintenant les deux colonnes pour que le bouton submit fonctionne sans
                        l'attribut 'form' --}}
                        <form action="{{ route('checkout.process') }}" id="checkoutForm" method="POST"
                            class="row g-3 mb-5 mt-3">
                            @csrf
                            @method('POST')
                            {{-- Colonne Formulaire (inchangée structurellement) --}}
                            <div class="col-6">

                                <p class="fs-4 text-decoration-underline text-secondary" style="color:#8f7212 !important;">
                                    *Veuillez renseigner les Informations de Facturation </p>

                                {{-- Nom Complet --}}
                                <div class="inputGroup my-3">
                                    <input type="text" id="name" name="client_name"
                                        value="{{ old('client_name', $checkoutInfo['client_name'] ?? '') }}" required
                                        autocomplete="off" class="@error('client_name') is-invalid @enderror">
                                    <label for="name">Nom Complet *</label>
                                    @error('client_name')
                                        <div class="text-danger mt-1">{{ $errors->first('client_name') }}</div>
                                    @enderror
                                </div>

                                {{-- Pays --}}
                                <div class="my-3">
                                    <div class="form-group">
                                        <select name="pays" class="form-select rounded-5 @error('pays') is-invalid @enderror"
                                            required>
                                            <option value="TG" {{ old('pays', 'TG') == 'TG' ? 'selected' : '' }}>Togo
                                            </option>
                                        </select>
                                        @error('pays')
                                            <div class="text-danger mt-1">{{ $errors->first('pays') }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Ville --}}
                                <div class="inputGroup my-3">
                                    <input type="text" name="ville" id="ville" value="{{ old('ville') }}" required
                                        autocomplete="off" class="@error('ville') is-invalid @enderror">
                                    <label for="ville">Ville *</label>
                                    @error('ville')
                                        <div class="text-danger mt-1">{{ $errors->first('ville') }}</div>
                                    @enderror
                                </div>

                                {{-- Adresse --}}
                                <div class="inputGroup my-3">
                                    <input type="text" id="adresse" name="adresse" value="{{ old('adresse') }}" required
                                        autocomplete="off" class="@error('adresse') is-invalid @enderror">
                                    <label for="adresse">Adresse *</label>
                                    @error('adresse')
                                        <div class="text-danger mt-1">{{ $errors->first('adresse') }}</div>
                                    @enderror
                                </div>

                                {{-- Code Postal --}}
                                <div class="inputGroup my-3">
                                    <input type="text" id="code_postal" name="code_postal" value="{{ old('code_postal') }}"
                                        autocomplete="off" class="@error('code_postal') is-invalid @enderror">
                                    <label for="code_postal">Code postal</label>
                                    @error('code_postal')
                                        <div class="text-danger mt-1">{{ $errors->first('code_postal') }}</div>
                                    @enderror
                                </div>

                                {{-- Téléphone --}}
                                <div class="inputGroup my-3">
                                    <input type="tel" id="phone" name="client_phone"
                                        value="{{ old('client_phone', $checkoutInfo['client_phone'] ?? '') }}" required
                                        autocomplete="off" class="@error('client_phone') is-invalid @enderror">
                                    <label for="phone">Numéro de téléphone * (Format: +228XXXXXXXX ou XXXXXXXX)</label>
                                    @error('client_phone')
                                        <div class="text-danger mt-1">{{ $errors->first('client_phone') }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="inputGroup my-3">
                                    <input type="email" id="email" name="client_email"
                                        value="{{ old('client_email', $checkoutInfo['client_email'] ?? '') }}" required
                                        autocomplete="off" class="@error('client_email') is-invalid @enderror">
                                    <label for="email">Email *</label>
                                    @error('client_email')
                                        <div class="text-danger mt-1">{{ $errors->first('client_email') }}</div>
                                    @enderror
                                </div>

                                {{-- Mode de paiement --}}
                                <div class="payment-methods my-4">
                                    <p class="fs-4 text-decoration-underline text-secondary" style="color:#8f7212 !important;">
                                        *Choisissez votre mode de paiement</p>

                                    <div class="payment-options">
                                        <div class="payment-option">
                                            <input type="radio" id="cinetpay" name="payment_mode" value="cinetpay" disabled>
                                            <label for="cinetpay" class="payment-label"
                                                style="opacity: 0.6; cursor: not-allowed;">
                                                <i class="bi bi-credit-card-fill me-2"></i>
                                                Paiement en ligne
                                                <small class="d-block text-muted">Paiement sécurisé par CinetPay</small>
                                                <small class="d-block text-danger mt-1">Service temporairement
                                                    indisponible</small>
                                            </label>
                                        </div>

                                        <div class="payment-option">
                                            <input type="radio" id="livraison" name="payment_mode" value="livraison">
                                            <label for="livraison" class="payment-label">
                                                <i class="bi bi-cash-coin me-2"></i>
                                                Paiement à la livraison
                                                <small class="d-block text-muted">Payez en espèces à la réception</small>
                                            </label>
                                        </div>

                                        <div class="payment-option">
                                            <input type="radio" id="boutique" name="payment_mode" value="boutique">
                                            <label for="boutique" class="payment-label">
                                                <i class="bi bi-shop me-2"></i>
                                                Retrait en boutique
                                                <small class="d-block text-muted">Payez lors du retrait en magasin</small>
                                            </label>
                                        </div>
                                    </div>

                                    @error('payment_mode')
                                        <div class="alert alert-danger mt-2">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <style>
                                    .payment-methods {
                                        background: #f8f9fa;
                                        padding: 20px;
                                        border-radius: 8px;
                                    }

                                    .payment-options {
                                        display: flex;
                                        flex-direction: column;
                                        gap: 15px;
                                    }

                                    .payment-option {
                                        position: relative;
                                    }

                                    .payment-option input[type="radio"] {
                                        display: none;
                                    }

                                    .payment-label {
                                        display: block;
                                        padding: 15px;
                                        background: white;
                                        border: 2px solid #dee2e6;
                                        border-radius: 8px;
                                        cursor: pointer;
                                        transition: all 0.3s ease;
                                    }

                                    .payment-label:hover {
                                        border-color: #C70039;
                                    }

                                    .payment-option input[type="radio"]:checked+.payment-label {
                                        border-color: #C70039;
                                        background-color: #fff5f7;
                                    }

                                    .payment-label i {
                                        color: #C70039;
                                    }

                                    .payment-label small {
                                        margin-top: 5px;
                                        font-size: 0.85em;
                                    }

                                    .alert-danger {
                                        border-left: 4px solid #C70039;
                                    }
                                </style>


                            </div> {{-- Fin Colonne Formulaire col-6 --}}


                            {{-- Colonne Résumé Panier (inchangée structurellement) --}}
                            <div class="col-5 ms-auto d-flex flex-column justify-content-between">
                                <table class="table table-striped table-hover">
                                    {{-- Structure thead/tbody --}}
                                    <thead>
                                        <tr>
                                            <th scope="col">Produit Image</th>
                                            <th scope="col">Nom</th>
                                            <th scope="col">Prix</th>
                                            <th scope="col">Quantité</th>
                                            <th scope="col">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Vérifier si $items est non vide avant de boucler --}}
                                        @if (!empty($items))
                                            {{-- Boucle sur la collection $items --}}
                                            @foreach ($items as $item)
                                                {{-- Vérifier si le produit lié existe --}}
                                                @php
                                                    $produit =
                                                        $item instanceof \App\Models\Panier
                                                        ? $item->produit
                                                        : $item['produit'];
                                                    $quantite =
                                                        $item instanceof \App\Models\Panier
                                                        ? $item->quantite
                                                        : $item['quantite'];
                                                @endphp
                                                @if ($produit)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ asset('assets/produits/' . $produit->image) }}"
                                                                class="img-fluid product-image img-thumbnail"
                                                                style="object-fit: cover; cursor: pointer; width: 100px; height: 100px"
                                                                data-full-image="{{ asset('assets/produits/' . $produit->image) }}">
                                                        </td>
                                                        <td>{{ $produit->name }}</td>
                                                        <td>{{ number_format($produit->prix, 0, ',', ' ') }}</td>
                                                        <td>{{ $quantite }}</td>
                                                        <td>{{ number_format($produit->prix * $quantite, 0, ',', ' ') }}
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-danger text-center">Un produit
                                                            n'est plus disponible.</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">Panier vide.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                                                            <div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators">
        @foreach($pubs as $key => $pub)
            <button type="button" 
                    data-bs-target="#carouselExampleIndicators" 
                    data-bs-slide-to="{{ $key }}"
                    @if($key === 0) class="active" aria-current="true" @endif
                    aria-label="Slide {{ $key + 1 }}">
            </button>
        @endforeach
    </div>
    
    <div class="carousel-inner rounded carousel-img-fixed">
        @forelse($pubs as $key => $pub)
            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                <img src="{{ asset('assets/pubs/' . $pub->image) }}"
                     class="d-block w-100 img-fluid" 
                     alt="{{ $pub->titre }}">
            </div>
        @empty
            {{-- Image par défaut si aucune pub n'est trouvée --}}
            <div class="carousel-item active">
                <img src="{{ asset('user/images/boutique1-bg.jpg') }}"
                     class="d-block w-100 img-fluid" 
                     alt="Image par défaut">
            </div>
        @endforelse
    </div>

    @if($pubs->count() > 1)
        <button class="carousel-control-prev" type="button"
                data-bs-target="#carouselExampleIndicators" 
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button"
                data-bs-target="#carouselExampleIndicators" 
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    @endif
</div>

                            <style>
    .carousel-img-fixed {
        width: 100%;
        height: 180px;
        overflow: hidden;
    }

    .carousel-img-fixed img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        border-radius: 5px;
        padding: 10px;
    }

    .carousel-caption h5 {
        color: white;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    .carousel-caption p {
        color: #fff;
        font-size: 0.9rem;
        margin-bottom: 0;
    }
</style>

                                {{-- <style>
                                    .carousel-img-fixed {
                                        width: 100%;
                                        height: 180px;
                                        object-fit: cover;
                                    }
                                </style> --}}

                                <div class="card pt-2" style="background-color: #eee;">
                                    <div class="card-body">
                                        <h1 class="card-title fw-bold my-4">Total Prix</h1>
                                        <hr>
                                        <div class="fs-4 fw-normal "><span>Total Produit: </span> <span
                                                class="float-end">{{ $totalProduitPanier ?? 0 }}</span></div>
                                        <div class="fs-4 fw-normal "><span>Total Panier: </span> <span
                                                class="float-end">{{ number_format($totalPrixPanier, 0, ',', ' ') }}
                                                FCFA</span></div>
                                        <div class="fs-4 fw-normal "><span>Livraison: </span> <span class="float-end"
                                                style="color: #C70039 !important;">A payer sur place</span></div>
                                        <hr>
                                        <div class="fs-4 fw-normal "><span>Total: </span> <span
                                                class="float-end">{{ number_format($totalPrixPanier, 0, ',', ' ') }}
                                                FCFA</span></div>
                                    </div>
                                </div>

                            </div> {{-- Fin Colonne Résumé Panier col-5 --}}

                            {{-- Bouton de soumission (placé DANS le formulaire, après les colonnes) --}}
                            <a href="" class="text-decoration-none d-flex justify-content-center py-5 my-3">
                                <button class="animated-button" type="submit" form="checkoutForm">
                                    <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                        </path>
                                    </svg>
                                    <span class="text">Je valide ma Commande </span>
                                    <span class="circle"></span>
                                    <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                        </path>
                                    </svg>
                                </button>
                            </a>

                        </form> {{-- Fin du <form> --}}
                    @else
                            {{-- Message si le panier est vide (sécurité) --}}
                            <div class="col-12">
                                <div class="alert alert-warning text-center">
                                    Votre panier est vide. <a href="{{ route('user.boutique') }}">Retournez à la boutique</a>
                                    pour ajouter des produits.
                                </div>
                            </div>
                        @endif

                </div> {{-- Fin .row global --}}
            </div> {{-- Fin .container --}}
        </section>

    </main>



@endsection


{{-- Scripts (inchangés) --}}
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ton code JS pour le modal image (inchangé)
            const productImages = document.querySelectorAll('.product-image');
            // ... (le reste de ton code modal) ...

            // Ton code JS pour le bouton (inchangé, mais vérifie si la classe 'processing' existe dans ton CSS)
            const checkoutForm = document.getElementById('checkoutForm');
            // ... (le reste de ton code bouton) ...
        });
    </script>
@endpush