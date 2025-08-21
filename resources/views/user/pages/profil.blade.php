@extends('layouts.user')

@section('titre')
Profil | El-Papiro
@endsection

@section("panier")
active
@endsection

@section('main')

<main>
  <section id="boutique1" class="mb-5 pb-5">
      <div class="banner ">
        <div class="banner-over pt-lg-3 pb-lg-2 px-lg-0 px-2">
          <div class="banner-texte container pt-5 my-5">
            <div class="row">
              <h1 class="text-center fw-bold">Boutique</h1>
              <p class="fs-4">
                  <a href="{{ route('user.index') }}" style="color: var(--color-jaune);">Accueil</a>
                  <span style="color: #3d3838;">/</span>
                  <span>Boutique</span>
              </p>
            </div>
          </div>
        </div>
      </div>
  </section>

  <section id="boutique2" class="mb-5 pb-5 ">
      <div class="container">
        <hr style="color: #C70039;">
        <h1 class="fs-1 fw-bold" style="color: #C70039;">Tous nos produits . . .</h1> <hr style="color: #C70039;">
          <br>

          <div class="row ligne1">
              <div class="col colonne1">
                
              </div>
          </div>

          <div class="row row-cols-2">

          </div>


      </div>


  </section>




</main>

@endsection