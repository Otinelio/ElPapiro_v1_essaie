<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">



        <li class="nav-item">
            <a class="nav-link @yield('produit') btn btn-danger" href="{{ route('staff.produit.index') }}">

                <span>Produits</span>
            </a>
        </li>



        <li class="nav-item">
            <a class="nav-link @yield('commande')" href="{{ route('staff.commande.index') }}">

                <span>Commandes</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @yield('paiement')" href="{{ route('staff.paiement.index') }}">

                <span>Paiements</span>
            </a>
        </li>


        <li class="nav-item">
            <a class="nav-link @yield('livraisons')" href="{{ route('staff.livraisons.view') }}">

                <span>Livraisons</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link @yield('pubs')" href="{{ route('staff.pubs.view') }}">

                <span>Espace pubs</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link @yield('client')" href="{{ route('user.index') }}">

                <span>Aller sur le site</span>
            </a>
        </li>
        <!-- Déplacer le bouton de déconnexion en bas -->
        <div class="" style="margin-top: 100%">
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