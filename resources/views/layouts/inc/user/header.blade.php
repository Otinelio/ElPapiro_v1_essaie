<header>




    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-2" href="{{ route('user.index') }}">
              El-Papiro
            </a>
            <div class="d-flex align-items-center d-lg-none">
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse pt-2 pb-2" id="navbarSupportedContent">
              <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item mx-1">
                  <a class="nav-link @yield('accueil')" aria-current="page" href="{{ route("user.index") }}">Accueil</a>
                </li>
                <li class="nav-item mx-1">
                  <a class="nav-link @yield('boutique')" href="{{ route("user.boutique") }}">Boutique</a>
                </li>
                {{-- <li class="nav-item mx-1">
                  <a class="nav-link @yield('detailboutique')" href="{{ route("user.detailboutique", ) }}">Détail de la Boutique</a>
                </li> --}}
                <li class="nav-item mx-1">
                  <a class="nav-link @yield('panier')" href="{{ route("panier.index") }}">Panier</a>
                </li>
                <li class="nav-item mx-1">
                  <a class="nav-link @yield('checkout')" href="{{ route("user.checkout") }}">Check-out</a>
                </li>
              </ul>
              <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
               <div class="d-flex">
                {{-- Ajout du nouveau lien Mes Commandes --}}
                <style>
                  /* Ajouter ces styles dans votre fichier CSS ou dans une balise style */
                  .nav-link {
                      position: relative;
                      transition: color 0.3s ease;
                  }

                  .nav-link:hover {
                      color: #C70039 !important;
                  }

                  .nav-link .badge {
                      position: absolute;
                      top: 5px;
                      right: -5px;
                      font-size: 0.75rem;
                      padding: 0.25em 0.6em;

                  }

                  /* Style spécifique pour le lien actif */
                  .nav-link.active {
                      color: #C70039 !important;
                      font-weight: 500;
                  }

                  /* Animation du badge */
                  @keyframes pulse {
                      0% { transform: scale(1); }
                      50% { transform: scale(1.1); }
                      100% { transform: scale(1); }
                  }

                  .badge {
                      animation: pulse 2s infinite;
                  }
                  </style>

                <li class="nav-item me-2">
                <a class="nav-link" href="{{route("panier.index")}}">
                  <i class="bi bi-cart-fill">
                    <span style="font-size: 12px" class="@yield('beta') rounded-circle bg-danger">
                      @yield("alpha")
                      <span class="visually-hidden">unread messages</span>
                    </span>
                  </i>
                </a>
                </li>
                    {{-- <!-- Ajout du compteur de favoris -->
                    <li class="nav-item me-2">
                        <a class="nav-link" href="{{ route('favoris') }}">
                            <i class="bi bi-heart-fill">
                                <span style="font-size: 12px" class="favoris-count rounded-circle bg-danger {{ count(Session::get('favoris', [])) > 0 ? '' : 'd-none' }}">
                                    {{ count(Session::get('favoris', [])) }}
                                    <span class="visually-hidden">favoris</span>
                                </span>
                            </i>
                        </a>
                    </li> --}}
               </div>
              </ul>
            </div>
        </div>
    </nav>
</header>
