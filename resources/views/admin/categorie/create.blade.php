@extends('layouts.admin')

@section("title")
Catégories - Créer
@endsection

@section("categorie")
collapsed
@endsection

@section("section")


<section class="section dashboard-produits">
    <div class="row">
      <div class="card">
        <div class="card-header">
         <span class="card-title fs-3">Ajouter une catégorie</span>
          <a href="{{ route('categorie.index') }}" class="btn btn-primary float-end">Retour</a>
        </div>
        <div class="card-body">
          <form action="{{ route('categorie.store') }}" method="POST" class="row g-3 my-3">
              @csrf
              <div class="col-12">
                  <label for="name" class="form-label  card-title py-0">Nom de la catégorie</label>
                  <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Entrer le nom de la catégorie">
              </div>
              @error('name')
                <div class="text-danger">{{ $message }}</div>
              @enderror

              <div class="col-12 my-3">
                <label for="description" class="form-label  card-title py-0">Description de la catégorie</label>
                <textarea class="form-control" id="description" name="description" placeholder="Entrer la description de la catégorie" rows="3"></textarea>
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