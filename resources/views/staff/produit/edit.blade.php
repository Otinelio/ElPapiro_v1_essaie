@extends('layouts.staff')

@section("title")
Modifier un produit
@endsection

@section("produit")
collapsed
@endsection

@section("section")
<style>
    .image-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.8);
        align-items: center;
        justify-content: center;
    }
    .image-modal-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        max-width: 80%;
        max-height: 80%;
        position: relative;
        text-align: center;
    }
    .image-modal-close {
        position: absolute;
        top: 40px;
        right: 100px;
        color: white;
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
    }
    .image-modal-img {
        max-width: 100%;
        max-height: 80vh;
        width: auto;
        height: auto;
        object-fit: contain;
    }
  </style>
    <section class="section dashboard-produits">
      <div class="row">
        <div class="card">
          <div class="card-header">
           <span class="card-title fs-3">Modifier un produit</span>
            <a href="{{ route('staff.produit.index') }}" class="btn btn-primary float-end">Retour</a>
          </div>
          <div class="card-body">
            <form action="{{ route('staff.produit.update', $produit->id) }}" method="POST" class="row g-3 my-3" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                    <label for="name" class="form-label  card-title py-0">Nom du produit</label>
                    <input type="text" name="name" value="{{ $produit->name }}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Entrer le nom du produit">

                    @error('name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror

                </div>
                <div class="col-md-6">
                    <label for="categorie" class="form-label  card-title py-0">Categorie du produit</label>
                    <select class="form-select @error('categorie_id') is-invalid @enderror" name="categorie_id" id="categorie">
                        <option selected value="{{ $produit->categorie_id }}">{{ $produit->categorie->name }}</option>
                        @foreach ($categorie as $item )
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="sous_categorie" class="form-label  card-title py-0">Sous categorie du produit</label>
                    <select class="form-select @error('sous_categorie') is-invalid @enderror" name="sous_categorie" id="sous_categorie">
                      <option selected value="{{ $produit->sous_categorie }}">{{ $produit->sous_categorie }}</option>
                        @foreach(\App\Models\Produit::SOUS_CATEGORIES as $categorie)
                        <option value="{{ $categorie }}">{{ $categorie }}</option>
                        @endforeach
                  </select>
                </div>
                <div class="col-md-6">
                    <label for="prix" class="form-label  card-title py-0">Prix du produit</label>
                    <input type="number" name="prix" value="{{ $produit->prix }}" class="form-control @error('prix') is-invalid @enderror" id="prix" placeholder="Entrer le prix du produit">

                    @error('prix')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="quantite" class="form-label  card-title py-0">Quantité en stock</label>
                    <input type="number" name="quantite" value="{{ $produit->quantite_stock }}" class="form-control @error('quantite') is-invalid @enderror" id="quantite" placeholder="Entrer la quantité du produit">

                    @error('quantite')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="description" class="form-label  card-title py-0">Description du produit</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="5" placeholder="Entrer la description du produit">
                        {{ $produit->description }}
                    </textarea>

                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-12">
                  <label for="image" class="form-label  card-title py-0">Image du produit</label>

                  <div class=" my-3">
                    <img src="{{ asset('assets/produits/' . $produit->image) }}"
                         class="img-fluid product-image"
                         width="200px"
                         style="object-fit: cover; cursor: pointer;"
                         data-full-image="{{ asset('assets/produits/' . $produit->image) }}">
                  </div>

                  <input name="image"  class="form-control custom-file-input  @error('image') is-invalid @enderror" id="image" type="file">



                  @error('image')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-12">
                  <button class="btn btn-primary float-end mt-4" type="submit">Modifier</button>
                </div>

            </form>
          </div>
        </div>
      </div>
    </section>
@endsection
