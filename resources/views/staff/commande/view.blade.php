@extends('layouts.staff')

@section('title')
    Commandes
@endsection

@section('commande')
    collapsed
@endsection



@section('section')
    <section class="py-5">
        <div class="container">
            <div class="card border-0 shadow rounded-4">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between py-3 px-4">
                    <h5 class="mb-0 fw-semibold text-secondary">📋 Commandes</h5>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover align-middle mb-0">
                            <thead class="bg-light text-muted small text-uppercase text-center">
                                <tr>
                                    <th>#NCM</th>
                                    <th>Client</th>
                                    <th>Montant</th>
                                    <th>Moyen de paiement</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($commandes as $commande)
                                    <tr class="text-center border-top">
                                        <td class="fw-medium text-dark">{{ $commande->numero_commande }}</td>
                                        <td>{{ $commande->nom_client }}</td>
                                        <td class="fw-bold">{{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
                                        </td>
                                        <td>
                                            @php
                                                $paymentMethods = [
                                                    'especes' => 'Espèces',
                                                    'orange-money' => 'Orange Money',
                                                    'wave' => 'Wave',
                                                    'free-money' => 'Free Money',
                                                ];
                                            @endphp
                                            <span class="badge bg-info bg-opacity-25 text-info fw-semibold">
                                                {{ $paymentMethods[$commande->mode_paiement] ?? ucfirst($commande->mode_paiement) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'en_attente' => 'warning',
                                                    'terminee' => 'success',
                                                    'annulee' => 'danger',
                                                ];
                                                $color = $statusColors[$commande->statut] ?? 'secondary';
                                            @endphp
                                            <span
                                                class="badge bg-{{ $color }} bg-opacity-25 text-{{ $color }} fw-semibold">
                                                {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                                            </span>
                                        </td>
                                        <td class="text-muted">{{ $commande->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('staff.commande.show', $commande) }}"
                                                    class="btn btn-sm btn-light border text-primary">
                                                    Voir
                                                </a>
                                                @if ($commande->statut !== 'annulee' && $commande->statut !== 'terminee')
                                                    <a href="{{ route('staff.commande.edit', $commande) }}"
                                                        class="btn btn-sm btn-light border text-warning">
                                                        Modifier
                                                    </a>
                                                @else
                                                    <a class="btn btn-sm btn-light border text-secondary disabled"
                                                        aria-disabled="true" tabindex="-1" style="pointer-events: none;">
                                                        Modifier
                                                    </a>
                                                @endif
                                                {{-- <form action="{{ route('staff.commande.destroy', $commande) }}"
                                                    method="POST" onsubmit="return confirm('Supprimer cette commande ?')"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light border text-danger">
                                                        Supprimer
                                                    </button>
                                                </form> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">Aucune commande trouvée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card-footer bg-white text-center py-3">
                    {{ $commandes->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
