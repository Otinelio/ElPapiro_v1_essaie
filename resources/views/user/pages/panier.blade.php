@extends('layouts.user')

@section('titre')
    Panier | El-Papiro
@endsection

@section('panier')
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

        <section id="boutique1" class="mb-5 pb-5">
            <div class="banner ">
                <div class="banner-over pt-lg-3 pb-lg-2 px-lg-0 px-2">
                    <div class="banner-texte container pt-5 my-5">
                        <div class="row">
                            <h1 class="text-center fw-bold">Panier</h1>
                            <p class="fs-4">
                                <a href="{{ route('user.index') }}" style="color: var(--color-jaune);">Accueil</a>
                                <span style="color: #3d3838;">/</span>
                                <span>Panier</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="panier">
            <div class="container">
                <div class="row">
                    {{-- <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th scope="col">Produit</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody class="">
                          <tr>
                            <td>
                                    <img src="../images/sir_de_beaupré.jpg"
                                        class="img-fluid img-thumbnail cart-product-image" style="width: 100px;" alt="">
                            </td>
                            <td class="align-middle">3000 FCFA</td>
                            <td class="align-middle">
                                <p>
                                        <button onclick="decrement()" class="btn rounded-pill" style="padding: 1px 5px;"><i
                                                class="bi bi-dash"></i></button>
                                    <span id="counter" style="padding: 0 5px;">1</span>
                                        <button onclick="increment()" class="btn rounded-pill" style="padding: 1px 5px;"><i
                                                class="bi bi-plus"></i></button>
                                </p>
                            </td>
                            <td class="align-middle">6000 FCFA</td>
                            <td class="align-middle">
                                <i class="bi bi-trash btn btn-danger"></i>
                            </td>
                          </tr>
                          <tr>
                            <td>
                                    <img src="../images/sir_de_beaupré.jpg"
                                        class="img-fluid img-thumbnail cart-product-image" style="width: 100px;" alt="">
                            </td>
                            <td class="align-middle">3000 FCFA</td>
                            <td class="align-middle">
                                <p>
                                        <button onclick="decrement()" class="btn rounded-pill" style="padding: 1px 5px;"><i
                                                class="bi bi-dash"></i></button>
                                    <span id="counter" style="padding: 0 5px;">1</span>
                                        <button onclick="increment()" class="btn rounded-pill" style="padding: 1px 5px;"><i
                                                class="bi bi-plus"></i></button>
                                </p>
                            </td>
                            <td class="align-middle">6000 FCFA</td>
                            <td class="align-middle">
                                <i class="bi bi-trash btn btn-danger"></i>
                            </td>
                          </tr>
                          <tr>
                            <td>
                                    <img src="../images/sir_de_beaupré.jpg"
                                        class="img-fluid img-thumbnail cart-product-image" style="width: 100px;" alt="">
                            </td>
                            <td class="align-middle">3000 FCFA</td>
                            <td class="align-middle">
                                <p>
                                        <button onclick="decrement()" class="btn rounded-pill" style="padding: 1px 5px;"><i
                                                class="bi bi-dash"></i></button>
                                    <span id="counter" style="padding: 0 5px;">1</span>
                                        <button onclick="increment()" class="btn rounded-pill" style="padding: 1px 5px;"><i
                                                class="bi bi-plus"></i></button>
                                </p>
                            </td>
                            <td class="align-middle">6000 FCFA</td>
                            <td class="align-middle">
                                <i class="bi bi-trash btn btn-danger"></i>
                            </td>
                          </tr>
                        </tbody>
                      </table> --}}

                    @if (session('success') || session('error') || session('info'))
                        <div
                            class="alert alert-{{ session('success') ? 'success' : (session('error') ? 'danger' : 'info') }}">
                            {{ session('success') ?? (session('error') ?? session('info')) }}
                        </div>
                    @endif
                    <span class="text-secondary">*N'oubliez pas de cliquer sur modifier à chaque fois que vous modifier la
                        quantité d'un produit</span>
                    <table class="table table-striped table-hover">
                        <tr>
                            <th scope="col">Produit Image</th>
                            <th scope="col">Produit Nom</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Quantité</th>
                            <th scope="col">Total</th>
                            <th scope="col">Action</th>
                        </tr>

                        @if ($items->count() > 0)
                            @foreach ($items as $item)
                                <tr>
                                    <td>

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
                                                background-color: rgba(0, 0, 0, 0.8);
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
                                                top: 100px;
                                                right: 100px;
                                                color: white;
                                                font-size: 35px;
                                                font-weight: bold;
                                                cursor: pointer;
                                            }

                                            .image-modal-img {
                                                margin-top: 80px;
                                                max-width: 100%;
                                                max-height: 80vh;
                                                width: auto;
                                                height: auto;
                                                object-fit: contain;
                                            }
                                        </style>

                                        <img src="{{ asset('assets/produits/' . $item['produit']->image) }}"
                                            class="img-fluid product-image img-thumbnail"
                                            style="object-fit: cover; cursor: pointer; width: 100px; height: 100px"
                                            data-full-image="{{ asset('assets/produits/' . $item['produit']->image) }}">
                                        {{-- <img src="{{ asset('assets/produits/' . $item['produit']->image) }}"
                                            class="img-fluid img-thumbnail cart-product-image" style="width: 100px; height: 100px;"
                                            alt=""> --}}
                                    </td>
                                    <td>{{ $item['produit']->name }}
                                        <p class=""><a
                                                href="{{ route('user.detailboutique', $item['produit']->slug) }}"
                                                style="color: rgb(184, 184, 4);">Détails du produit</a></p>
                                    </td>
                                    <td>{{ number_format($item['produit']->prix) }}</td>
                                    <td>

                                        <style>
                                            .quantity-minus,
                                            .quantity-plus {
                                                width: 32px;
                                                padding: 0.25rem 0.5rem;
                                                transition: all 0.3s ease;
                                            }

                                            .quantity-minus:hover,
                                            .quantity-plus:hover {
                                                background-color: #b31212;
                                            }

                                            .quantity-input {
                                                -moz-appearance: textfield;
                                                border-left: none;
                                                border-right: none;
                                            }

                                            .quantity-input::-webkit-outer-spin-button,
                                            .quantity-input::-webkit-inner-spin-button {
                                                -webkit-appearance: none;
                                                margin: 0;
                                            }
                                        </style>

                                        <form method="POST" action="{{ route('panier.update', $item['produit']->id) }}"
                                            class="d-flex align-items-center" onsubmit="return validateQuantity(this)">
                                            @csrf
                                            @method('PATCH')
                                            <div class="input-group" style="max-width: 110px;">
                                                <button type="button"
                                                    class="btn btn-outline-secondary btn-sm quantity-minus"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                    <i class="bi bi-dash"></i>
                                                </button>
                                                <input type="number" name="quantite" value="{{ $item['quantite'] }}"
                                                    min="1" class="form-control text-center quantity-input"
                                                    style="border-color: #dee2e6;">
                                                <button type="button"
                                                    class="btn btn-outline-secondary btn-sm quantity-plus"
                                                    onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                    <i class="bi bi-plus"></i>
                                                </button>
                                            </div>
                                            <button type="submit" class="btn btn-warning btn-sm ms-2"
                                                style="background-color: #ffc107; border-color: #ffc107;">
                                                <i class="bi bi-arrow-repeat">Modifier</i>
                                            </button>
                                            <div class="text-danger ms-2 quantity-error" style="display: none;">La quantité
                                                doit
                                                être supérieure à 0</div>
                                        </form>
                                    </td>
                                    <td>{{ number_format($item['produit']->prix * $item['quantite']) }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('panier.remove', $item['produit']->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border-0"
                                                onclick="return confirm('Voulez vous vraiment supprimer ce produit ??')">
                                                <i class="bi bi-trash btn btn-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">Votre panier est vide.</td>
                            </tr>
                        @endif
                    </table>

                    @if ($items->count() > 0)
                        <form method="POST" action="{{ route('panier.clear') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Voulez vous vraiment supprimer ce produit ??')">Vider le
                                panier</button>
                        </form>
                    @else
                        <div>
                            <a href="{{ route('user.boutique') }}" class="btn btn-danger">Visiter notre boutique</a>

                        </div>
                    @endif



                </div>
            </div>
        </section>

        <section id="total-panier" class="mb-5 pb-5">
            <div class="container">
                <div class="row my-5">
                    <div class="col-4 ms-auto my-5">
                        <div class="card pt-2 pb-3" style="background-color: #eee;">
                            <div class="card-body">
                                <h1 class="card-title fw-bold my-4">Total du panier</h1>
                                <hr>
                                <div class="fs-4 fw-normal "><span>Total de produit: </span> <span
                                        class="float-end">{{ $totalProduitPanier }}</span></div>
                                <div class="fs-4 fw-normal">
                                    <span>Total:</span>
                                    <span class="float-end">{{ number_format($totalPrixPanier) }} FCFA</span>
                                </div>
                                <div class=" mt-4 col-5 float-end">
                                    @if ($items->count() > 0)
                                        <a href="{{ route('user.checkout') }}"
                                            class="btn btn-warning text-decoration-none text-dark">Passer la commande</a>
                                    @else
                                        <span class="bg-warning text-decoration-none text-dark"
                                            style="cursor: not-allowed; opacity: 0.5;">Passer votre commande</span>
                                </div>
                            </div>

                        </div>
                        <p class="text-center text-danger">***Vous n'avez pas de produit dans votre panier</p>
                        @endif
                    </div>
                </div>
            </div>

        </section>

    </main>
    <script>
        document.querySelectorAll('.product-image').forEach(img => {
            img.addEventListener('click', () => {
                const modal = document.createElement('div');
                modal.classList.add('image-modal');
                modal.innerHTML = `
                    <div class="image-modal-content">
                        <span class="image-modal-close">&times;</span>
                        <img src="${img.dataset.fullImage}" class="image-modal-img">
                    </div>
                `;
                document.body.appendChild(modal);
                modal.style.display = 'flex';

                modal.querySelector('.image-modal-close').onclick = () => {
                    modal.remove();
                };

                modal.onclick = (e) => {
                    if (e.target === modal) modal.remove();
                };
            });
        });
    </script>

    @push('scripts')
        <script>
            function validateQuantity(form) {
                const quantityInput = form.querySelector('input[name="quantite"]');
                const errorDiv = form.querySelector('.quantity-error');
                const quantity = parseInt(quantityInput.value);

                if (quantity <= 0) {
                    errorDiv.style.display = 'block';
                    quantityInput.classList.add('is-invalid');
                    return false;
                }

                errorDiv.style.display = 'none';
                quantityInput.classList.remove('is-invalid');
                return true;
            }

            // Ajouter un écouteur d'événement pour cacher le message d'erreur lorsque l'utilisateur modifie la valeur
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('input', function() {
                    const errorDiv = this.closest('form').querySelector('.quantity-error');
                    if (parseInt(this.value) > 0) {
                        errorDiv.style.display = 'none';
                        this.classList.remove('is-invalid');
                    }
                });
            });
        </script>

        <style>
            .quantity-error {
                font-size: 0.875rem;
                margin-top: 0.25rem;
            }

            .is-invalid {
                border-color: #dc3545 !important;
            }
        </style>
    @endpush
@endsection
