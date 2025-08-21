@extends('layouts.admin')

@section("title")
Commandes
@endsection

@section("paiement")
collapsed
@endsection

@section('section')
<section class="py-5">
    <div class="container">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-bottom py-3 px-4">
                <h5 class="mb-0 fw-bold text-secondary">
                    💳 Validation du paiement pour la commande #{{ $commande->numero_commande ?? $commande->id }}
                </h5>
            </div>
            <div class="card-body px-4 py-4">
                @if(in_array($commande->statut, ['terminee', 'annulee']))
                    <div class="alert alert-info">
                        Cette commande est <strong>{{ ucfirst($commande->statut) }}</strong> et ne peut plus être modifiée.
                    </div>
                @else
                    <form action="{{ route('commande.valider.paiement.store', $commande) }}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="montant" class="form-label fw-semibold">Montant payé</label>
                                <input type="number" name="montant" id="montant" class="form-control" value="{{ $commande->montant_total }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="methode" class="form-label fw-semibold">Méthode de paiement</label>
                                <input type="text" name="methode" id="methode" class="form-control" value="{{ $commande->mode_paiement }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="statut" class="form-label fw-semibold">Statut du paiement</label>
                                <select name="statut" id="statut" class="form-select" required>
                                    <option value="effectue">Effectué</option>
                                    <option value="en_attente">En attente</option>
                                    <option value="echoue">Échoué</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Commande liée</label>
                                <input type="text" class="form-control" value="#{{ $commande->numero_commande ?? $commande->id }}" disabled>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-success fw-semibold">
                                <i class="bi bi-check-circle me-1"></i> Valider le paiement et la commande
                            </button>
                            <a href="{{ route('commande.edit', $commande) }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection