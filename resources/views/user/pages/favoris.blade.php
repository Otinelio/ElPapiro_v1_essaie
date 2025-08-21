@extends('layouts.user')

@section('titre')
    Favoris | El-Papiro
@endsection

@section('favoris')
    active
@endsection

@section('main')
    <main>
        <section id="boutique1" class="mb-5 pb-5">
            <div class="banner">
                <div class="banner-over pt-lg-3 pb-lg-2 px-lg-0 px-2">
                    <div class="banner-texte container pt-5 my-5">
                        <div class="row">
                            <h1 class="text-center fw-bold">Mes Favoris</h1>
                            <p class="fs-4">
                                <a href="{{ route('user.index') }}" style="color: var(--color-jaune);">Accueil</a>
                                <span style="color: #3d3838;">/</span>
                                <span>Favoris</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="favoris">
            <div class="container">
                <div class="row">
                    @if ($produits->count() > 0)
                        <div class="row">
                            @foreach ($produits as $produit)
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100">
                                        <img src="{{ asset('assets/produits/' . $produit->image) }}" class="card-img-top"
                                            alt="{{ $produit->name }}" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $produit->name }}</h5>
                                            <p class="card-text">{{ number_format($produit->prix) }} FCFA</p>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('user.detailboutique', $produit->slug) }}"
                                                    class="btn btn-warning">Voir détails</a>
                                                <label class="favoris">
                                                    <input type="checkbox" class="toggle-favori"
                                                        data-produit-id="{{ $produit->id }}" checked>
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="#ff0000">
                                                        <path
                                                            d="M12 20a1 1 0 0 1-.437-.1C11.214 19.73 3 15.671 3 9a5 5 0 0 1 8.535-3.536l.465.465.465-.465A5 5 0 0 1 21 9c0 6.646-8.212 10.728-8.562 10.9A1 1 0 0 1 12 20z">
                                                        </path>
                                                    </svg>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="col-12 text-center">
                            <h3>Vous n'avez pas encore de favoris</h3>
                            <a href="{{ route('user.boutique') }}" class="btn btn-warning mt-3">
                                Découvrir nos produits
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        <script>
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
                                this.checked = true;
                            } else {
                                svg.setAttribute('fill', '#000000');
                                this.checked = false;
                            }
                            updateFavorisCount();
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            // Remettre le checkbox dans son état précédent en cas d'erreur
                            this.checked = !this.checked;
                        });
                });
            });

            function updateFavorisCount() {
                fetch('/favoris/count')
                    .then(response => response.json())
                    .then(data => {
                        const countElement = document.querySelector('.favoris-count');
                        if (countElement) {
                            countElement.textContent = data.count;
                            if (data.count === 0) {
                                countElement.classList.add('d-none');
                            } else {
                                countElement.classList.remove('d-none');
                            }
                        }
                    });
            }
        </script>
    @endpush
@endsection
