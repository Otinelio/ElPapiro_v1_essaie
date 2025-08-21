@extends('layouts.staff')

@section('title')
    Test Staff
@endsection

@section('section')
    <div class="container py-5">
        <div class="card">
            <div class="card-header">
                <h3>Test Staff - Routes fonctionnelles</h3>
            </div>
            <div class="card-body">
                <h5>Routes disponibles :</h5>
                <ul>
                    <li><a href="{{ route('staff.commande.index') }}">Liste des commandes</a></li>
                    <li><a href="{{ route('staff.paiement.index') }}">Liste des paiements</a></li>
                    <li><a href="{{ route('staff.produit.index') }}">Liste des produits</a></li>
                    <li><a href="{{ route('staff.categorie.index') }}">Liste des catégories</a></li>
                </ul>

                <hr>
                <h5>Informations de session :</h5>
                <p><strong>Utilisateur :</strong> {{ Auth::user()->name ?? 'Non connecté' }}</p>
                <p><strong>Rôle :</strong> {{ Auth::user()->role ?? 'Non défini' }}</p>
                <p><strong>URL actuelle :</strong> {{ request()->url() }}</p>
            </div>
        </div>
    </div>
@endsection





