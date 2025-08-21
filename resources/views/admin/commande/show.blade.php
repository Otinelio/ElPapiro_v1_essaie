@extends('layouts.admin')

@section("title")
Détail Commande
@endsection

@section("commande")
collapsed
@endsection

@section("section")
    <section class="py-5">
        <div class="container">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-secondary">
                        🧾 Détail de la commande #{{ $commande->numero_commande ?? $commande->id }}
                    </h5>
                    <a href="{{ route('commande.index') }}" class="btn btn-sm btn-outline-secondary">
                        ⬅ Retour à la liste
                    </a>
                </div>

                <div class="card-body px-4 py-4">
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">🧑 Informations du client</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 py-2"><strong>Nom :</strong> {{ $commande->nom_client ?? $commande->client_name }}</li>
                            <li class="list-group-item px-0 py-2"><strong>Email :</strong> {{ $commande->email_client ?? $commande->client_email }}</li>
                            <li class="list-group-item px-0 py-2"><strong>Téléphone :</strong> {{ $commande->telephone_client ?? $commande->client_phone }}</li>
                            <li class="list-group-item px-0 py-2">
                                <strong>Adresse :</strong> {{ $commande->adresse ?? '-' }}, {{ $commande->ville ?? '-' }}, {{ $commande->pays ?? '-' }}
                            </li>
                            <li class="list-group-item px-0 py-2">
                                <strong>Montant :</strong> <span class="fw-semibold text-dark">{{ number_format($commande->montant_total ?? $commande->prix_total, 0, ',', ' ') }} FCFA</span>
                            </li>
                            <li class="list-group-item px-0 py-2">
                                <strong>Moyen de paiement :</strong>
                                @php
    $paymentMethods = [
        'especes' => 'Espèces',
        'orange-money' => 'Orange Money',
        'wave' => 'Wave',
        'free-money' => 'Free Money'
    ];
                                @endphp
                                <span class="badge bg-info bg-opacity-25 text-info fw-semibold">
                                    {{ $paymentMethods[$commande->mode_paiement] ?? ucfirst($commande->mode_paiement) }}
                                </span>
                            </li>
                            <li class="list-group-item px-0 py-2">
                                <strong>Statut :</strong>
                                @php
    $status = $commande->statut ?? $commande->status;
    $color = match ($status) {
        'en_attente', 'pending' => 'warning',
        'terminee', 'completed' => 'success',
        'annulee', 'cancelled' => 'danger',
        default => 'secondary'
    };
                                @endphp
                                <span class="badge bg-{{ $color }} bg-opacity-25 text-{{ $color }} fw-semibold px-3 py-1">
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>
                            </li>
                            <li class="list-group-item px-0 py-2">
                                <strong>Date :</strong> {{ $commande->created_at->format('d/m/Y H:i') }}
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h6 class="text-muted mb-3">🛍️ Produits commandés</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th class="py-3">Produit</th>
                                        <th class="py-3">Prix Unitaire</th>
                                        <th class="py-3">Quantité</th>
                                        <th class="py-3">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($items as $item)
                                        <tr class="text-center">
                                            <td class="py-3">
                                                <div class="d-flex align-items-center">
                                                    @if($item->produit->image)
                                                        <img src="{{ asset('assets/produits/' . $item->produit->image) }}" alt="{{ $item->produit->nom }}"
                                                            class="rounded-3 me-3" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #eee;">
                                                    @else
                                                        <div class="rounded-3 me-3 bg-light d-flex align-items-center justify-content-center"
                                                            style="width: 80px; height: 80px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div class="text-start">
                                                        <h6 class="mb-1 fw-bold text-dark">{{ $item->produit->name ?? 'Produit non disponible' }}</h6>
                                                        @if($item->produit->description)
                                                            <small class="text-muted d-block">{{ Str::limit($item->produit->description, 50) }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">{{ number_format($item->prix, 0, ',', ' ') }} FCFA</td>
                                            <td class="py-3">
                                                <span class="badge bg-primary bg-opacity-25 text-primary fw-semibold">
                                                    {{ $item->quantite }}
                                                </span>
                                            </td>
                                            <td class="py-3 fw-bold">{{ number_format($item->prix * $item->quantite, 0, ',', ' ') }} FCFA</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">Aucun produit dans cette commande</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold py-3">Total de la commande :</td>
                                        <td class="text-center fw-bold py-3">{{ number_format($commande->montant_total ?? $commande->prix_total, 0, ',', ' ') }} FCFA</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
