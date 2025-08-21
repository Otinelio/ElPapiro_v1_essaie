@extends('layouts.admin')

@section("title")
Produits
@endsection

@section("produit")
collapsed
@endsection

@section('section')

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


  <section class="">
    <div class="row">
      <div class="card">
        <div class="card-header">

            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

         <span class="card-title fs-3">Liste des produits</span> <span class="badge bg-primary">{{ $total_produits }}</span>
          <a href="{{ route('produit.create') }}" class="btn btn-primary float-end">Ajouter un produit</a>
        </div>
        <div class="card-body">
          <table class="table table-dark table-striped">
            <thead>
              <tr>
                <th scope="col" class=" card-title py-0">ID</th>
                <th scope="col" class=" card-title py-0">Image</th>
                <th scope="col" class=" card-title py-0">Nom du produit</th>
                <th scope="col" class=" card-title py-0">Categorie</th>
                <th scope="col" class=" card-title py-0">Prix (FCFA)</th>
                <th scope="col" class=" card-title py-0">Qté stock</th>
                <th scope="col" class=" card-title py-0">Action</th>
              </tr>
            </thead>
            <tbody>
                @if ($produit->count() > 0)
                @foreach ($produit as $item)
                <tr>
                  <th scope="row" class=" card-title py-0">{{ $item->id }}</th>

                  <td>
                    <img src="{{ asset('assets/produits/' . $item->image) }}"
                         class="img-fluid product-image"
                         width="50px"
                         style="object-fit: cover; cursor: pointer;"
                         alt="{{ $item->name }}"
                         data-full-image="{{ asset('assets/produits/' . $item->image) }}">
                </td>

                  <td>{{ $item->name }}</td>

                  <td>{{ $item->categorie_name }} <br>
                    <span class="text-success fst-italic">{{ $item->sous_categorie }}</span>
                    </td>

                  <td>{{ $item->prix }}</td>

                  <td>{{ $item->quantite_stock }}</td>

                  <td>
                    <a href="{{ route('produit.show', $item->slug) }}" class="my-2 btn btn-info btn-sm">Voir</a>
                    <a href="{{ route('produit.edit', $item->slug) }}" class="btn btn-warning btn-sm">Modifier</a>
                    <form action="{{ route('produit.destroy', $item->id) }}" class="mt-2" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Voulez vous vraiment supprimer ce produit ??')">Supprimer</button>
                    </form>
                  </td>
                </tr>
                @endforeach

                @else
                  <tr>
                    <td colspan="7">Pas de produit</td></td>
                  </tr>
                @endif
            </tbody>
          </table>
        </div>
        {{ $produit->appends(request()->query())->links() }}
      </div>
    </div>
  </section>


@endsection







