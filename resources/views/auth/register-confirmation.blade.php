<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription confirmée | El Papiro</title>

    <!-- Vendor CSS Files -->
    <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">

    <style>
        :root {
            --primary-color: #C70039;
            --secondary-color: #FFC300;
        }

        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            font-family: 'Roboto', sans-serif;
        }

        .confirmation-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .confirmation-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            text-align: center;
            max-width: 600px;
            width: 100%;
            border: 3px solid var(--primary-color);
        }

        .success-icon {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 1.5rem;
        }

        .confirmation-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .confirmation-message {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
            font-size: 1.1rem;
        }

        .btn-custom {
            background-color: var(--primary-color);
            border: none;
            color: var(--secondary-color);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #a30030;
            color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .info-box {
            background: #e8f4f8;
            border-left: 4px solid #0dcaf0;
            padding: 1.5rem;
            border-radius: 10px;
            margin: 2rem 0;
            text-align: left;
        }

        .info-box h5 {
            color: #0dcaf0;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="confirmation-container">
        <div class="confirmation-card">
            <div class="success-icon">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <h1 class="confirmation-title">Inscription confirmée !</h1>

            <p class="confirmation-message">
                Félicitations ! Votre compte a été créé avec succès.
                Vous recevrez bientôt un email de confirmation.
            </p>

            <div class="info-box">
                <h5><i class="bi bi-info-circle me-2"></i>Prochaines étapes</h5>
                <ul class="mb-0">
                    <li>Vérifiez votre boîte email pour confirmer votre compte</li>
                    <li>Votre compte sera validé par l'administration dans les plus brefs délais</li>
                    <li>Vous recevrez une notification dès que votre compte sera activé</li>
                </ul>
            </div>

            <div class="d-flex flex-column gap-3">
                <a href="{{ route('user.index') }}" class="btn btn-custom">
                    <i class="bi bi-house-fill"></i>
                    Retour à l'accueil
                </a>

                <a href="{{ route('user.boutique') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-shop"></i>
                    Visiter notre boutique
                </a>
            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
