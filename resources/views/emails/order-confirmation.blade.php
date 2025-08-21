<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmation de commande - El Papiro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .order-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .product-list {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .product-list th, .product-list td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 1.2em;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #C70039;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Confirmation de commande</h1>
        <p>Merci pour votre commande chez El Papiro !</p>
    </div>

    <div class="order-details">
        <h2>Détails de la commande #{{ $commande->numero_commande }}</h2>

       <h3>Informations client</h3>
    <p><strong>Nom :</strong> {{ $commande->nom_client }}</p>
    <p><strong>Email :</strong> {{ $commande->email_client }}</p>
    <p><strong>Téléphone :</strong> {{ $commande->telephone_client }}</p>
    <p><strong>Adresse :</strong> {{ $commande->adresse }}, {{ $commande->ville }}, {{ $commande->pays }}</p>
    </div>

    <h3>Produits commandés</h3>
    <table class="product-list">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item['produit']['name'] }}</td>
                <td>{{ $item['quantite'] }}</td>
                <td>{{ number_format($item['prix'], 0, ',', ' ') }} FCFA</td>
                <td>{{ number_format($item['prix'] * $item['quantite'], 0, ',', ' ') }} FCFA</td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Aucun produit trouvé</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="total">
        Total de la commande : {{ number_format($commande->montant_total, 0, ',', ' ') }} FCFA
    </div>

    <div style="text-align: center;">
        <a href="{{ route('checkout.resume', $commande->numero_commande) }}" class="button">Voir le détail de ma commande</a>
    </div>

    <div class="footer">
        <p>Pour toute question concernant votre commande, n'hésitez pas à nous contacter.</p>
        <p>Merci de votre confiance en El Papiro !</p>
    </div>
</body>
</html>
