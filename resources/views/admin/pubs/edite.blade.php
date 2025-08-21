@extends('layouts.admin')

@section('title')
    Modifier une Publicité
@endsection

@section('pubs')
    active
@endsection

@section('section')
    <div class="container-fluid px-4">
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                Modifier la Publicité
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pubs.update', $pub) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="titre" class="form-label">Titre</label>
                        <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre"
                            value="{{ old('titre', $pub->titre) }}" required>
                        @error('titre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description">{{ old('description', $pub->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="position_page" class="form-label">Position et Page</label>
                        <select class="form-select @error('position_page') is-invalid @enderror" id="position_page"
                            name="position_page" required>

                            {{-- Afficher la position actuelle en premier --}}
                            <option value="{{ $current_position }}" selected>
                                {{ ucfirst(str_replace('_', ' - ', $current_position)) }}
                                (Position actuelle)
                            </option>

                            <optgroup label="Page Boutique">
                                @foreach(['banner', 'section1', 'section2'] as $position)
                                    @php $pos = "boutique_{$position}"; @endphp
                                    @if(!in_array($pos, $positions_utilisees) && $pos !== $current_position)
                                        <option value="{{ $pos }}">
                                            Boutique -
                                            {{ ucfirst(str_replace(['banner', 'section'], ['Bannière', 'Section '], $position)) }}
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>

                            <optgroup label="Page Détail Boutique">
                                @foreach(['banner', 'section1', 'section2'] as $position)
                                    @php $pos = "detail-boutique_{$position}"; @endphp
                                    @if(!in_array($pos, $positions_utilisees) && $pos !== $current_position)
                                        <option value="{{ $pos }}">
                                            Détail Boutique -
                                            {{ ucfirst(str_replace(['banner', 'section'], ['Bannière', 'Section '], $position)) }}
                                        </option>
                                    @endif
                                @endforeach
                            </optgroup>

                            <optgroup label="Page Checkout">
                                @foreach(['banner', 'section1', 'section2'] as $position)
                                    @php $pos = "checkout_{$position}"; @endphp
                                    @if(!in_array($pos, $positions_utilisees) && $pos !== $current_position)
                                        <option value="{{ $pos }}">
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

                    <div class="mb-3">
                        <label for="image" class="form-label">Image actuelle</label>
                        <div class="mb-2">
                            <img src="{{ asset('assets/pubs/' . $pub->image) }}" alt="{{ $pub->titre }}"
                                style="max-height: 200px;">
                        </div>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                            accept="image/*">
                        <small class="text-muted">Laissez vide pour conserver l'image actuelle</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    <a href="{{ route('admin.pubs.view') }}" class="btn btn-secondary">Annuler</a>
                </form>
            </div>
        </div>
    </div>
@endsection