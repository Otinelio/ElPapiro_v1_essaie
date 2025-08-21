@extends('layouts.admin')

@section('title')
    Modifier Commande #{{ $commande->numero_commande ?? $commande->id }}
@endsection

@section('commande')
    collapsed
@endsection

@section('section')
    <section class="py-5">
        <div class="container">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-secondary">
                        ✏️ Modifier la commande #{{ $commande->numero_commande ?? $commande->id }}
                    </h5>
                    <a href="{{ route('commande.index') }}" class="btn btn-sm btn-outline-secondary">
                        ⬅ Retour à la liste
                    </a>
                </div>

                <div class="card-body px-4 py-4">
                    @if (in_array($commande->statut, ['terminee', 'annulee']))
                        <div class="alert alert-info">
                            Cette commande est <strong>{{ ucfirst($commande->statut) }}</strong> et ne peut plus être
                            modifiée.
                        </div>
                    @else
                        <form action="{{ route('commande.update', $commande) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="statut" class="form-label fw-semibold">Statut de la commande</label>
                                <select name="statut" id="statut" class="form-select" required>
                                    <option value="en_attente" {{ $commande->statut == 'en_attente' ? 'selected' : '' }}>En
                                        attente</option>
                                    <option value="terminee" {{ $commande->statut == 'terminee' ? 'selected' : '' }}
                                        {{ !$paiementValide ? 'disabled' : '' }}>Terminée</option>
                                    <option value="annulee" {{ $commande->statut == 'annulee' ? 'selected' : '' }}>Annulée
                                    </option>
                                </select>
                                @if (!$paiementValide)
                                    <div class="text-danger mt-2">Le paiement doit être validé avant de pouvoir terminer la
                                        commande.</div>
                                @endif
                            </div>
                            @if ($paiement && $paiement->statut !== 'effectue')
                                <form action="{{ route('staff.paiement.valider', $paiement) }}" method="POST"
                                    class="mb-3">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary">Valider le paiement</button>
                                </form>
                            @endif

                            {{-- Tu peux ajouter d'autres champs modifiables ici si nécessaire --}}

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('commande.valider.paiement', $commande) }}"
                                    class="btn btn-success">Valider le paiement</a>
                                <form action="{{ route('commande.annuler', $commande) }}" method="POST"
                                    onsubmit="return confirm('Annuler cette commande ?')" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-danger">Confirmer</button>
                                </form>
                                <a href="{{ route('commande.index') }}" class="btn btn-outline-secondary">Retour</a>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
