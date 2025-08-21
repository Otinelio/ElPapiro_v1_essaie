  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">El-Papiro</span>
      </a>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" role="search">
        <input type="text" name="search" placeholder="Recherche" value="{{ Request::get('search') }}">
        <button type="submit"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">
            <strong>Staff</strong>

        </li><!-- End Notification Nav -->


        <li class="nav-item dropdown pe-3">


          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>K. Anderson</h6>
              <span>Administrateur</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-person"></i>
                <span>Mon Profil</span>
              </a>
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-gear"></i>
                <span>Paramètres</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf

                  <a href="{{ route('logout') }}" class="dropdown-item d-flex align-items-center text-danger"
                          onclick="event.preventDefault();
                                      this.closest('form').submit();">
                      <i class="bi bi-box-arrow-right"></i>
                      {{ __('Déconnexion') }}
                  </a>
              </form>
            </li>
          </ul>

        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->