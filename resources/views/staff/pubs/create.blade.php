@extends('layouts.staff')

@section('title')
    Ajouter une Publicité
@endsection

@section('pubs')
    collapsed
@endsection

@section('section')
    <div class="container-fluid px-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-image me-1"></i>
                Nouvelle Publicité
            </div>
            <div class="card-body">
                <form action="{{ route('staff.pubs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre"
                            value="{{ old('titre') }}" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                            accept="image/*" required>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="position" class="form-label">Position et Page</label>
                        <select class="form-select @error('position_page') is-invalid @enderror" id="position_page"
                            name="position_page" required>
                            <option value="">Sélectionnez une position</option>

                            <optgroup label="Page Boutique">
                                @foreach(['banner', 'section1', 'section2'] as $position)
                                    @if(!in_array("boutique_$position", $positions_utilisees))
                                        <option value="boutique_{{ $position }}">
                                            Boutique -
                                            {{ ucfirst(str_replace(['banner', 'section'], ['Bannière', 'Section '], $position)) }}
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>

                            <optgroup label="Page Détail Boutique">
                                @foreach(['banner', 'section1', 'section2'] as $position)
                                    @if(!in_array("detail-boutique_$position", $positions_utilisees))
                                        <option value="detail-boutique_{{ $position }}">
                                            Détail Boutique -
                                            {{ ucfirst(str_replace(['banner', 'section'], ['Bannière', 'Section '], $position)) }}
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>

                            <optgroup label="Page Checkout">
                                @foreach(['banner', 'section1', 'section2'] as $position)
                                    @if(!in_array("checkout_$position", $positions_utilisees))
                                        <option value="checkout_{{ $position }}">
                                            Checkout -
                                            {{ ucfirst(str_replace(['banner', 'section'], ['Bannière', 'Section '], $position)) }}
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>
                        </select>
                        @error('position_page')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <a href="{{ route('staff.pubs.view') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
@endsection