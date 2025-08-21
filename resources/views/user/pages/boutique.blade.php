@extends('layouts.user')

@section('titre')
    Boutique | El-Papiro
@endsection

@section('boutique')
    active
@endsection

@section('beta')
    {{ $totalProduitPanier > 0 ? 'badge' : '' }}
@endsection

@section('alpha')
    {{ $totalProduitPanier > 0 ? $totalProduitPanier : null }}
@endsection


@section('main')
    <main>
        <section id="boutique1" class="pb-2">
            <div class="banner">
                <div class="banner-over pt-lg-3 pb-lg-2 px-lg-0 px-2">
                    <div class="banner-texte container pt-5 my-0 my-sm-5">
                        <div class="row">
                            <h1 class="text-center fw-bold">
                                Boutique</h1>
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
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <hr style="color: #C70039;">
                <h1 class="fs-1 fw-bold" style="color: #C70039;">Tous nos produits . . .</h1>
                <hr style="color: #C70039;">


                <div class="row ligne1">
                    <div class="col pt-2 pb-4 colonne1">

                        <form class="searchBox col-lg-3 col-12 rounded" role="search" action="{{ route('user.boutique') }}"
                            method="GET">
                            <input class="searchInput" type="text" value="{{ Request::get('search') }}" name="search"
                                placeholder="Mots-clés">
                            <button type="submit" class="searchButton" href="#">



                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29"
                                    fill="none">
                                    <g clip-path="url(#clip0_2_17)">
                                        <g filter="url(#filter0_d_2_17)">
                                            <path
                                                d="M23.7953 23.9182L19.0585 19.1814M19.0585 19.1814C19.8188 18.4211 20.4219 17.5185 20.8333 16.5251C21.2448 15.5318 21.4566 14.4671 21.4566 13.3919C21.4566 12.3167 21.2448 11.252 20.8333 10.2587C20.4219 9.2653 19.8188 8.36271 19.0585 7.60242C18.2982 6.84214 17.3956 6.23905 16.4022 5.82759C15.4089 5.41612 14.3442 5.20435 13.269 5.20435C12.1938 5.20435 11.1291 5.41612 10.1358 5.82759C9.1424 6.23905 8.23981 6.84214 7.47953 7.60242C5.94407 9.13789 5.08145 11.2204 5.08145 13.3919C5.08145 15.5634 5.94407 17.6459 7.47953 19.1814C9.01499 20.7168 11.0975 21.5794 13.269 21.5794C15.4405 21.5794 17.523 20.7168 19.0585 19.1814Z"
                                                stroke="white" stroke-width="3" stroke-linecap="round"
                                                stroke-linejoin="round" shape-rendering="crispEdges"></path>
                                        </g>
                                    </g>
                                    <defs>
                                        <filter id="filter0_d_2_17" x="-0.418549" y="3.70435" width="29.7139"
                                            height="29.7139" filterUnits="userSpaceOnUse"
                                            color-interpolation-filters="sRGB">
                                            <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
                                            <feColorMatrix in="SourceAlpha" type="matrix"
                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha">
                                            </feColorMatrix>
                                            <feOffset dy="4"></feOffset>
                                            <feGaussianBlur stdDeviation="2"></feGaussianBlur>
                                            <feComposite in2="hardAlpha" operator="out"></feComposite>
                                            <feColorMatrix type="matrix"
                                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"></feColorMatrix>
                                            <feBlend mode="normal" in2="BackgroundImageFix"
                                                result="effect1_dropShadow_2_17"></feBlend>
                                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_2_17"
                                                result="shape"></feBlend>
                                        </filter>
                                        <clipPath id="clip0_2_17">
                                            <rect width="28.0702" height="28.0702" fill="white"
                                                transform="translate(0.403503 0.526367)"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>


                            </button>
                        </form>

                    </div>
                </div>

                <div class="row row-cols-2">
                    <div class="col-12 col-md-3 my-2">
                        <div class="row">
                            <article class="fw-semibold">
                                <h3 class="fw-bold" style="color: #C70039;">Produits</h3>
                                <article>

                                    <p>Total de produit <span class="float-end"
                                            style="color: #FFC300;">{{ $total_produits }}</span></p>

                                </article>

                                @foreach ($categories as $item)
                                    <article>

                                        <p>
                                            <a href="{{ route('user.boutique', ['search' => $item->name]) }}" class="">

                                                {{ $item->name }} <span class="float-end"
                                                    style="color: #FFC300;">{{ $item->produits->count() }}</span>
                                            </a>
                                        </p>

                                    </article>
                                @endforeach
                            </article>
                            <div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators">
        @foreach($pubs as $key => $pub)
            <button type="button" 
                    data-bs-target="#carouselExampleIndicators" 
                    data-bs-slide-to="{{ $key }}"
                    @if($key === 0) class="active" aria-current="true" @endif
                    aria-label="Slide {{ $key + 1 }}">
            </button>
        @endforeach
    </div>
    
    <div class="carousel-inner rounded carousel-img-fixed">
        @forelse($pubs as $key => $pub)
            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                <img src="{{ asset('assets/pubs/' . $pub->image) }}"
                     class="d-block w-100 img-fluid" 
                     alt="{{ $pub->titre }}">
            </div>
        @empty
            {{-- Image par défaut si aucune pub n'est trouvée --}}
            <div class="carousel-item active">
                <img src="{{ asset('user/images/boutique1-bg.jpg') }}"
                     class="d-block w-100 img-fluid" 
                     alt="Image par défaut">
            </div>
        @endforelse
    </div>

    @if($pubs->count() > 1)
        <button class="carousel-control-prev" type="button"
                data-bs-target="#carouselExampleIndicators" 
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Précédent</span>
        </button>
        <button class="carousel-control-next" type="button"
                data-bs-target="#carouselExampleIndicators" 
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Suivant</span>
        </button>
    @endif
</div>

                            <style>
    .carousel-img-fixed {
        width: 100%;
        height: 180px;
        overflow: hidden;
    }

    .carousel-img-fixed img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .carousel-caption {
        background: rgba(0, 0, 0, 0.5);
        border-radius: 5px;
        padding: 10px;
    }

    .carousel-caption h5 {
        color: white;
        margin-bottom: 5px;
        font-size: 1.1rem;
    }

    .carousel-caption p {
        color: #fff;
        font-size: 0.9rem;
        margin-bottom: 0;
    }
</style>

                            {{-- <article class="my-3">
                                <div class="mt-4">
                                    <img src="../images/boissons&vins_boutique.jpg" alt="" class="img-fluid img-thumbnail">
                                </div>
                                <div class="mt-4">
                                    <img src="../images/produits_alimentaires_boutique.jpg" alt=""
                                        class="img-fluid img-thumbnail">
                                </div>
                                <div class="mt-4">
                                    <img src="../images/produits_laitiers_boutique.jpg" alt=""
                                        class="img-fluid img-thumbnail">
                                </div>
                                <div class="mt-4">
                                    <img src="../images/produits_menagers_boutique.jpg" alt=""
                                        class="img-fluid img-thumbnail">
                                </div>

                            </article> --}}
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 ">
                            @foreach ($produits as $item)
                                <div class="col">
                                    <div class="card h-100">
                                        <div class="image-container">
                                            <img src="{{ asset('assets/produits/' . $item->image) }}" alt="">
                                            <div class="price">{{ number_format($item->prix) }} FCFA</div>
                                        </div>
                                        <label class="favorite">
                                            <input checked="" type="checkbox">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#000000">
                                                <path
                                                    d="M12 20a1 1 0 0 1-.437-.1C11.214 19.73 3 15.671 3 9a5 5 0 0 1 8.535-3.536l.465.465.465-.465A5 5 0 0 1 21 9c0 6.646-8.212 10.728-8.562 10.9A1 1 0 0 1 12 20z">
                                                </path>
                                            </svg>
                                        </label>

                                        <div class="content">
                                            <div class="brand">{{ $item->name }}</div>
                                            <div class="product-name">{{ $item->categorie_name }}</div>
                                            <p class=""><a href="{{ route('user.detailboutique', $item->slug) }}"
                                                    style="color: rgb(184, 184, 4);">Détails du produit</a></p>
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
                        <div class="d-flex justify-content-end mt-5">
                            {{ $produits->links() }}
                        </div>
                    </div>
                </div>


            </div>


        </section>




    </main>
@endsection