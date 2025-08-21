@extends('layouts.staff')

@section('title')
    Espace Pubs
@endsection

@section('pubs')
    collapsed
@endsection

@section('section')
<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <i class="fas fa-image me-1"></i>
        Liste des Publicités
    </div>
    @if($peutAjouter)
        <a href="{{ route('staff.pubs.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Ajouter
        </a>
    @else
        <button class="btn btn-secondary btn-sm" disabled title="Toutes les positions sont occupées">
            <i class="fas fa-plus"></i> Ajouter
        </button>
    @endif
</div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @unless($peutAjouter)
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i>
            Toutes les positions de publicité sont occupées (9/9).
        </div>
    @endunless

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Emplacement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pubs as $pub)
                        <tr>
                            <td>
                                <img src="{{ asset('assets/pubs/' . $pub->image) }}" 
                                     alt="{{ $pub->titre }}" 
                                     style="max-height: 50px;">
                            </td>
                            <td>{{ $pub->titre }}</td>
                            <td>
                @switch($pub->page)
                    @case('boutique')
                        <span class="badge bg-primary">Page Boutique</span>
                    @break
                    @case('detail-boutique')
                        <span class="badge bg-info">Page Détail</span>
                    @break
                    @case('checkout')
                        <span class="badge bg-warning">Page Checkout</span>
                    @break
                @endswitch
                -
                @switch($pub->position)
                    @case('banner')
                        <span class="badge bg-secondary">Bannière</span>
                    @break
                    @case('section1')
                        <span class="badge bg-secondary">Section 1</span>
                    @break
                    @case('section2')
                        <span class="badge bg-secondary">Section 2</span>
                    @break
                @endswitch
            </td>
                            <td>
                                <a href="{{ route('staff.pubs.edit', $pub) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('staff.pubs.destroy', $pub) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette publicité ?')">
                                        <i class="bi bi-archive"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucune publicité trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection