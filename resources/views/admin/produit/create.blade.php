@extends('layouts.admin')

@section('title')
    Ajouter un produit
@endsection

@section('produit')
    collapsed
@endsection

@section('section')
    <section class="section dashboard-produits">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    <span class="card-title fs-3">Ajouter un produit</span>
                    <a href="{{ route('produit.index') }}" class="btn btn-primary float-end">Retour</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('produit.store') }}" method="POST" class="row g-3 my-3"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <label for="name" class="form-label  card-title py-0">Nom du produit</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                placeholder="Entrer le nom du produit">

                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="col-md-6">
                            <label for="categorie" class="form-label  card-title py-0">Categorie du produit</label>
                            <select class="form-select @error('categorie_id') is-invalid @enderror" name="categorie_id"
                                id="categorie">
                                <option selected hidden>Selectionner une catégorie</option>
                                @foreach ($categorie as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('categorie_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="col-md-6">
                            <label for="sous_categorie" class="form-label  card-title py-0">Sous categorie du
                                produit</label>
                            <select class="form-select @error('sous_categorie') is-invalid @enderror" name="sous_categorie"
                                id="sous_categorie">
                                <option selected hidden>Selectionner une sous-catégorie</option>
                                @foreach (\App\Models\Produit::SOUS_CATEGORIES as $categorie)
                                    <option value="{{ $categorie }}"
                                        {{ old('sous_categorie') == $categorie ? 'selected' : '' }}>{{ $categorie }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="prix" class="form-label  card-title py-0">Prix du produit</label>
                            <input type="number" name="prix" value="{{ old('prix') }}"
                                class="form-control @error('prix') is-invalid @enderror" id="prix"
                                placeholder="Entrer le prix du produit">

                            @error('prix')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="quantite" class="form-label  card-title py-0">Quantité en stock</label>
                            <input type="number" name="quantite" value="{{ old('quantite') }}"
                                class="form-control @error('quantite') is-invalid @enderror" id="quantite"
                                placeholder="Entrer la quantité du produit">

                            @error('quantite')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="description" class="form-label  card-title py-0">Description du produit</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                rows="5" placeholder="Entrer la description du produit">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="image" class="form-label  card-title py-0">Image du produit</label>
                            <input name="image" class="form-control @error('image') is-invalid @enderror" id="image"
                                type="file">

                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary float-end mt-4" type="submit">Ajouter</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
