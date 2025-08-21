@extends('layouts.admin')

@section('title')
    Catégories
@endsection

@section('categorie')
    collapsed
@endsection

@section('section')


    <section class="section dashboard-categorie">
      <div class="row">
        <div class="card w-75 mx-auto">
          <div class="card-header">

            @if (session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

           <span class="card-title fs-3">Liste des Catégories</span>
            <a href="{{ route('categorie.create') }}" class="btn btn-primary float-end">Ajouter une catégorie</a>
          </div>
          <div class="card-body">
            <table class="table table-dark table-striped">
              <thead>
                <tr>
                  <th scope="col" class=" card-title py-0">ID</th>
                  <th scope="col" class=" card-title py-0">Nom de la catégorie</th>
                  <th scope="col" class=" card-title py-0">Action</th>
                </tr>
              </thead>
              <tbody>
                @if ($categorie->count() > 0)
                @foreach ($categorie as $item)
                <tr>
                  <th scope="row" class=" card-title py-0">{{ $item->id }}</th>
                  <td>{{ $item->name }}</td>
                  <td>
                    <form action="{{ route('categorie.destroy', $item->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm " onclick="return confirm('Voulez vous vraiment supprimer ce produit ??')"><i class="bi bi-archive-fill btn text-danger"></i></button>
                    </form>
                  </td>
                </tr>
                @endforeach

                @else
                  <tr>
                    <td colspan="3">Pas de categorie</td>
                  </tr>
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>

@endsection
