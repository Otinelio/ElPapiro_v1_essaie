<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">



        <li class="nav-item">
            <a class="nav-link @yield('produit') btn btn-danger" href="{{ route('produit.index') }}">

                <span>Produits</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @yield('categorie')" href="{{ route('categorie.index') }}">

                <span>Catégories</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link @yield('commande')" href="{{ route('commande.index') }}">

                <span>Commandes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @yield('paiement')" href="{{ route('paiement.index') }}">

                <span>Paiements</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link @yield('livraisons')" href="{{ route('admin.livraisons.view') }}">

                <span>Livraisons</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @yield('personnels')" href="{{ route('admin.personnels.view') }}">

                <span>Personnels</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @yield('pubs')" href="{{ route('admin.pubs.view') }}">

                <span>Espace Pubs</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @yield('client')" href="{{ route('user.index') }}">

                <span>Aller sur le site</span>
            </a>
        </li>
        <!-- Déplacer le bouton de déconnexion en bas -->
        <div class="" style="margin-top: 80%">
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="dropdown-item d-flex align-items-center text-danger" onclick="event.preventDefault();
                            this.closest('form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        {{ __('Déconnexion') }}
                    </a>
                </form>
            </li>
        </div>
    </ul>

    </ul>


</aside><!-- End Sidebar-->