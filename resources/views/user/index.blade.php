@extends('layouts.user')

@section('titre')
    Accueil
@endsection

@section('accueil')
    active
@endsection

@section('beta')
    {{ $totalProduitPanier > 0 ? 'badge' : '' }}
@endsection

@section('alpha')
    {{ $totalProduitPanier > 0 ? $totalProduitPanier : null }}
@endsection


@section('main')
    <main id="mainmain">


        <section id="section1" class="">

            <div class="banner">
                <div class="banner-over pt-lg-3 pb-lg-2 px-lg-0 px-2">
                    <div class="banner-texte container py-5 my-5">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="row">
                            <p class="fs-4">Produits Sains et Authentiques</p>
                            <div class="col-lg-6 col-12 mx-auto ">
                                <h1 style="font-size: 40px !important; font-weight: 700;">On vous proposes des produits
                                    sains et authentiques pour un quotidien sain et confortable</h1>
                                <br>
                                <div>
                                    {{-- <form role="search" class="search mt-2 mb-3" action="{{ route('user.boutique') }}" method="GET">
        <input placeholder="Rechercher..." value="{{ Request::get('search') }}" name="search" type="text" class="px-5 py-3 rounded-pill"> --}}
                                    <form role="search" class="search mt-2 mb-3" action="{{ route('user.boutique') }}"
                                        method="GET" id="searchForm" onsubmit="return validateSearch()">
                                        <input placeholder="Rechercher..." value="{{ Request::get('search') }}"
                                            name="search" type="text" class="px-5 py-3 rounded-pill" id="searchInput">
                                        <button type="submit" class="px-4 py-3 rounded-pill">Aller</button>
                                        <div id="searchError" class="text-danger mt-2" style="display: none;">Veuillez
                                            entrer un mot clé</div>
                                    </form>
                                    <h6 class="ms-5" style="color: #313233;">ou ...</h6>
                                    <a href="{{ route('user.boutique') }}" class="text-decoration-none  mt-3 pb-5">
                                        <button class="animated-button">
                                            <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                                </path>
                                            </svg>
                                            <span class="text">Visiter notre boutique</span>
                                            <span class="circle"></span>
                                            <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                                </path>
                                            </svg>
                                        </button>
                                    </a>
                                </div>
                                <br>
                            </div>
                            <div class="col-lg-5 col-12 mx-auto ">


                                <div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">
                                    <div class="carousel-inner rounded-3">
                                        <div class="carousel-item active w-100">
                                            <img src="{{ asset('user/images/produit-alimentaire.jpg') }}"
                                                class="d-block w-100" alt="...">
                                            <div
                                                class="w-100 h-100 position-absolute top-0 start-0 d-flex justify-content-center align-items-center">
                                                <div>
                                                    <a href="" class="text-decoration-none ">
                                                        <p class="text-white m-0 fs-4 rounded-3">Produits Alimentaires</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="carousel-item w-100">
                                            <img src="{{ asset('user/images/produit-de-soin.jpg') }}" class="d-block w-100"
                                                alt="...">
                                            <div
                                                class="w-100 h-100 position-absolute top-0 start-0 d-flex justify-content-center align-items-center">
                                                <div>
                                                    <a href="" class="text-decoration-none ">
                                                        <p class="text-white m-0 fs-4 rounded-3">Produits de Soins</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="carousel-item w-100">
                                            <img src="{{ asset('user/images/produit-menagers.jpg') }}" class="d-block w-100"
                                                alt="...">
                                            <div
                                                class="w-100 h-100 position-absolute top-0 start-0 d-flex justify-content-center align-items-center">
                                                <div>
                                                    <a href="" class="text-decoration-none ">
                                                        <p class="text-white m-0 fs-4 rounded-3">Produits Ménagers</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleRide" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleRide" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>


                            </div>
                        </div>



                    </div>
                </div>

            </div>



        </section>

        <section id="selection">

            <div class="container py-5 carousel-container">
                <div class="container">
                    <hr style="color: #C70039;">
                    <h1 class="fs-1 fw-bold" style="color: #C70039;">Sélection du moment . . .</h1>
                    <hr style="color: #C70039;">
                </div>
                <div class="row py-5 px-lg-0 px-2 gy-5">

                    @foreach ($produits->take(8) as $item)
                        <div class="col-lg-3 col-md-4 col-6 ">
                            <div class="card h-100">
                                <div class="image-container">
                                    <img src="{{ asset('assets/produits/' . $item->image) }}" alt=""
                                        class="card-img-top">

                                    <div class="price">{{ number_format($item->prix) }} FCFA</div>
                                </div>
                                <label class="favorite">
                                    <input type="checkbox" class="toggle-favori" data-produit-id="{{ $item->id }}"
                                        {{ in_array($item->id, array_keys(Session::get('favoris', []))) ? 'checked' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="{{ in_array($item->id, array_keys(Session::get('favoris', []))) ? '#ff0000' : '#000000' }}">
                                        <path
                                            d="M12 20a1 1 0 0 1-.437-.1C11.214 19.73 3 15.671 3 9a5 5 0 0 1 8.535-3.536l.465.465.465-.465A5 5 0 0 1 21 9c0 6.646-8.212 10.728-8.562 10.9A1 1 0 0 1 12 20z">
                                        </path>
                                    </svg>
                                </label>

                                <div class="content">
                                    <div class="brand">{{ $item->name }}</div>
                                    <div class="product-name">{{ $item->categorie->name }}</div>
                                    <p class=""><span>{{ $item->description }}</span> <a
                                            href="{{ route('user.detailboutique', $item->slug) }}">Détails</a></p>

                                </div>

                                <div class="button-container mt-auto">
                                    <button class="buy-button button" form="buy-form-{{ $item->id }}">Buy
                                        Now</button>
                                    <form id="buy-form-{{ $item->id }}"
                                        action="{{ route('panier.add', ['produit' => $item->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $item->id }}">
                                        <input type="hidden" name="quantite" value="1" min="1">
                                        <input type="hidden" name="redirect_to" value="panier">
                                    </form>
                                    <form action="{{ route('panier.add', ['produit' => $item->id]) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produit_id" value="{{ $item->id }}">
                                        <input type="hidden" name="quantite" value="1" min="1">
                                        <button type="submit" class="cart-button button">
                                            <i class="bi bi-cart-plus-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>



                        </div>
                    @endforeach

                </div>

                <a href="{{ route('user.boutique') }}" class="text-decoration-none d-flex justify-content-center pb-5">
                    <button class="animated-button">
                        <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                            </path>
                        </svg>
                        <span class="text">Voir plus </span>
                        <span class="circle"></span>
                        <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                            </path>
                        </svg>
                    </button>
                </a>

            </div>
        </section>

        <section id="nosProduits">
            <div class="container py-5">
                <hr style="color: #C70039;">
                <h1 class="fs-1 fw-bold" style="color: #C70039;">Nos minis catégories . . .</h1>
                <hr style="color: #C70039;">
                <div class="row py-5 gy-5 px-lg-0 px-2 d-flex justify-content-center">

                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Huiles']) }}" class="text-decoration-none ">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/huile.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0">Huiles</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Pâtes']) }}" class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/pate.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0">Pâtes</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Conserves']) }}" class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/conserve.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0">Conserves</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Produits Laitiers']) }}"
                            class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/lait.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0 fs-6">Produits Laitiers</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Sucres & Edulcolorants']) }}"
                            class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/sucre.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0 fs-6">Sucres & Edulcolorants</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Produits à base de Chocolat']) }}"
                            class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/chocolat.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0 fs-6">Produits à base de Chocolat</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Condiments']) }}" class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/condiment.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0">Condiments</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Vins & Boissons']) }}"
                            class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/vin-boisson.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0 fs-6">Vins & Boissons</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Soins du Visage']) }}"
                            class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/soins-visage.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0 fs-6">Soins du Visage</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Hygiène Bucco-Dentaire']) }}"
                            class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/dentaire.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0 fs-6">Hygiène Bucco-Dentaire</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Soins Corporels']) }}"
                            class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/savon.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0 fs-6">Soins Corporels</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Nettoyants']) }}" class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/nettoyant.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0">Nettoyants</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <a href="{{ route('user.boutique', ['search' => 'Désodorisants']) }}"
                            class="text-decoration-none">
                            <div class="card py-3 h-100">
                                <div class="card-details">
                                    <img src="{{ asset('user/images/desodorisant.png') }}" alt=""
                                        class="img-fluid w-75">
                                    <p class="text-title py-0 my-0">Désodorisants</p>
                                    <hr class="py-0 my-0">
                                </div>
                                <button class="card-button">Visiter</button>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </section>

        <section id="procedure">
            <div class="container-fluid pt-5">
                <div class="container">
                    <hr style="color: #C70039;">
                    <h1 class="fs-1 fw-bold" style="color: #C70039;">Comment ça marche ?</h1>
                    <hr style="color: #C70039;">
                    <div class="row pt-5 pb-2 px-lg-0 px-2 d-flex justify-content-center align-items-center text-center">
                        <div class="col-lg-4 col-md-5 col-6">
                            <img src="{{ asset('user/images/choix-de-produit.png') }}" alt="" class="w-50">
                            <br><br>
                            <h1 class="fs-5" style="color: #C70039;">1. Je choisis mes produits préférés</h1>
                            <p class="fs-6" style="color: rgba(0, 0, 0, 0.678);">Faites votre choix parmi notre large
                                gamme de produits
                                depuis chez vous.</p>
                        </div>
                        <div class="col-lg-4 col-md-5 col-6">
                            <img src="{{ asset('user/images/Paiement-processus.png') }}" alt="" class="w-50">
                            <br><br>
                            <h1 class="fs-5" style="color: #C70039;">2. Je règle ma commande en ligne</h1>
                            <p class="fs-6" style="color: rgba(0, 0, 0, 0.678);">Je règle ma commande en ligne via les
                                moyens de paiement. Possibilité de régler à la livraison.
                            </p>
                        </div>
                        <div class="col-lg-4 col-md-5 col-6">
                            <img src="{{ asset('user/images/livraison-processus.png') }}" alt="" class="w-50">
                            <br><br>
                            <h1 class="fs-5" style="color: #C70039;">3. Je récupère ma commande</h1>
                            <p class="fs-6" style="color: rgba(0, 0, 0, 0.678);">Vous pouvez récupérer votre commande en
                                boutique, en Point
                                retrait ou vous faire livrer.</p>
                        </div>
                    </div>

                    <a href="{{ route('user.boutique') }}"
                        class="text-decoration-none d-flex justify-content-center pb-5">
                        <button class="animated-button">
                            <svg viewBox="0 0 24 24" class="arr-2" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                </path>
                            </svg>
                            <span class="text">Commander </span>
                            <span class="circle"></span>
                            <svg viewBox="0 0 24 24" class="arr-1" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z">
                                </path>
                            </svg>
                        </button>
                    </a>

                </div>
            </div>

            <div class="container-fluid oti">
                <div class="container"></div>
                <div class="row py-3  px-lg-0 px-2 d-flex justify-content-center align-items-center text-center">
                    <div class="col-lg-4 col-md-5 col-6">
                        <img src="{{ asset('user/images/commande-processus.png') }}" alt="" class="mb-2"
                            width="70px">

                        <p class="fs-6" style="color: rgb(255, 255, 255);">Vos commandes <br> <span
                                style="color: #FFC300; font-style: italic;">soigneusement préparées</span></p>
                    </div>
                    <div class="col-lg-4 col-md-5 col-6">
                        <img src="{{ asset('user/images/livraison2-processus.png') }}" alt="" class="mb-2"
                            width="70px">

                        <p class="fs-6" style="color: rgb(255, 255, 255);"><span
                                style="color: #FFC300; font-style: italic">3 modes de livraison</span> <br> à votre
                            disposition</p>
                    </div>
                    <div class="col-lg-4 col-md-5 col-6">
                        <img src="{{ asset('user/images/paiement2-processus.png') }}" alt="" class="mb-2"
                            width="70px">

                        <p class="fs-6" style="color: rgb(255, 255, 255);">Un paiement <br> <span
                                style="color: #FFC300; font-style: italic">100% sécurisé</span> </p>
                    </div>
                </div>
            </div>
            </div>
        </section>



        <!-- <section id="temoignage">
                      <div class="container py-5">
                      <div class="row  px-lg-0 mt-5 mx-2 pb-5 pt-lg-3 pt-5 px-5 gy-2 g-lg-5 rounded-5">
                      <div class="col-lg-3 col-sm-6 col-10 mx-auto ">
                      <div class="flip-card">
                        <div class="flip-card-inner h-100 w-100">
                        <div class="flip-card-front ">
                        <p class="title ">FLIP CARD</p>
                        <p>Hover Me</p>
                        </div>
                        <div class="flip-card-back">
                        <p class="title">BACK</p>
                        <p>Leave Me</p>
                        </div>
                        </div>
                      </div>
                      </div>
                      <div class="col-lg-3 col-sm-6 col-10 mx-auto ">
                      <div class="flip-card">
                        <div class="flip-card-inner">
                        <div class="flip-card-front">
                        <p class="title">FLIP CARD</p>
                        <p>Hover Me</p>
                        </div>
                        <div class="flip-card-back">
                        <p class="title">BACK</p>
                        <p>Leave Me</p>
                        </div>
                        </div>
                      </div>
                      </div>
                      <div class="col-lg-3 col-sm-6 col-10 mx-auto">
                      <div class="flip-card">
                        <div class="flip-card-inner">
                        <div class="flip-card-front">
                        <p class="title">FLIP CARD</p>
                        <p>Hover Me</p>
                        </div>
                        <div class="flip-card-back">
                        <p class="title">BACK</p>
                        <p>Leave Me</p>
                        </div>
                        </div>
                      </div>
                      </div>
                      <div class="col-lg-3 col-sm-6 col-10 mx-auto">
                      <div class="flip-card">
                        <div class="flip-card-inner">
                        <div class="flip-card-front">
                        <p class="title">FLIP CARD</p>
                        <p>Hover Me</p>
                        </div>
                        <div class="flip-card-back">
                        <p class="title">BACK</p>
                        <p>Leave Me</p>
                        </div>
                        </div>
                      </div>
                      </div>
                      </div>
                      </div>
                    </section> -->


        <section id="section_cartes" class="">
            <div class="container py-5">
                <div class="row py-5 px-lg-0 px-2 gy-3">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card text-center py-3 px-2 h-100" style="background-color: #eaeff3;">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <img src="{{ asset('user/images/livraison-carte.png') }}" alt="" width="150px">
                            </div>
                            <div>
                                <h1 class="fs-4" style="color: #C70039;">Livraison gratuite</h1>
                                <p>Gratuit pour toute commande de plus de 300 $</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card text-center py-3 px-2 h-100" style="background-color: #eaeff3;">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <img src="{{ asset('user/images/paiement-carte.png') }}" alt="" width="150px">
                            </div>
                            <div>
                                <h1 class="fs-4" style="color: #C70039;">Paiement sécurisé</h1>
                                <p>Paiement 100% sécurisé</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card text-center py-3 px-2 h-100" style="background-color: #eaeff3;">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <img src="{{ asset('user/images/retour-carte.png') }}" alt="" width="150px">
                            </div>
                            <div>
                                <h1 class="fs-4" style="color: #C70039;">Retour sous 30 jours</h1>
                                <p>Garantie de remboursement de 30 jours</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="card text-center py-3 px-2 h-100" style="background-color: #eaeff3;">
                            <div class="d-flex justify-content-center align-items-center mb-2">
                                <img src="{{ asset('user/images/support-carte.png') }}" alt="" width="150px">
                            </div>
                            <div>
                                <h1 class="fs-4" style="color: #C70039;">Assistance 24h/24 et 7j/7</h1>
                                <p>Assistance rapide à chaque fois</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>





    </main>
    <script>
        function validateSearch() {
            const searchInput = document.getElementById('searchInput');
            const searchError = document.getElementById('searchError');

            if (searchInput.value.trim() === '') {
                searchError.style.display = 'block';
                return false;
            }

            searchError.style.display = 'none';
            return true;
        }

        document.querySelectorAll('.toggle-favori').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const produitId = this.dataset.produitId;
                const svg = this.nextElementSibling;

                fetch(`/favoris/toggle/${produitId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'added') {
                            svg.setAttribute('fill', '#ff0000');
                        } else {
                            svg.setAttribute('fill', '#000000');
                        }
                        updateFavorisCount();
                    });
            });
        });
    </script>
@endsection
