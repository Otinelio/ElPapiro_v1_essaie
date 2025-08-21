@extends('layouts.staff')

@section('title')
    Paiement
@endsection

@section('paiement')
    collapsed
@endsection

@section('section')
    <section class="py-5">
        <div class="container">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-secondary">
                        💳 Liste des paiements
                    </h5>
                </div>
                <div class="card-body px-4 py-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-center small text-uppercase">
                                <tr>
                                    <th>Montant payé</th>
                                    <th>Méthode</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Commande liée</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($paiements as $paiement)
                                    <tr class="text-center border-top">
                                        <td class="fw-bold text-dark">{{ number_format($paiement->montant, 0, ',', ' ') }}
                                            FCFA</td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-25 text-info fw-semibold">
                                                {{ ucfirst(str_replace('_', ' ', $paiement->methode)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'effectue' => 'success',
                                                    'en_attente' => 'warning',
                                                    'echoue' => 'danger',
                                                ];
                                                $color = $statusColors[$paiement->statut] ?? 'secondary';
                                            @endphp
                                            <span
                                                class="badge bg-{{ $color }} bg-opacity-25 text-{{ $color }} fw-semibold">
                                                {{ ucfirst($paiement->statut) }}
                                            </span>
                                        </td>
                                        <td class="text-muted">{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('staff.commande.show', $paiement->commande_id) }}"
                                                class="btn btn-sm btn-light border text-primary">
                                                #{{ $paiement->commande->numero_commande ?? $paiement->commande_id }}
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">Aucun paiement trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white text-center py-3">
                        {{ $paiements->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
