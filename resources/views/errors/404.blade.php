<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Page non trouvée | El Papiro</title>

    <!-- Vendor CSS Files -->
    <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Style css -->
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">

    <style>
        :root {
            --color-jaune: #FFC300;
            --color-rouge: #C70039;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .error-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            text-align: center;
            max-width: 600px;
            width: 100%;
            border: 3px solid var(--color-rouge);
        }

        .error-number {
            font-size: 8rem;
            font-weight: 900;
            color: var(--color-rouge);
            margin: 0;
            line-height: 1;
            text-shadow: 3px 3px 0px rgba(0, 0, 0, 0.1);
        }

        .error-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin: 1rem 0;
        }

        .error-message {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .error-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }

        .btn-primary-custom {
            background: var(--color-rouge);
            border: none;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .btn-primary-custom:hover {
            background: #a30030;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(199, 0, 57, 0.3);
        }

        .btn-secondary-custom {
            background: transparent;
            border: 2px solid var(--color-jaune);
            color: var(--color-jaune);
            padding: 10px 28px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .btn-secondary-custom:hover {
            background: var(--color-jaune);
            color: #333;
            transform: translateY(-2px);
        }

        .error-icon {
            font-size: 4rem;
            color: var(--color-jaune);
            margin-bottom: 1rem;
        }

        .breadcrumb-nav {
            margin-bottom: 2rem;
            font-size: 0.9rem;
        }

        .breadcrumb-nav a {
            color: var(--color-jaune);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-nav a:hover {
            color: var(--color-rouge);
        }

        .breadcrumb-nav .separator {
            color: #666;
            margin: 0 8px;
        }

        @media (max-width: 768px) {
            .error-card {
                padding: 2rem;
                margin: 1rem;
            }

            .error-number {
                font-size: 6rem;
            }

            .error-title {
                font-size: 2rem;
            }

            .error-actions {
                flex-direction: column;
            }

            .btn-primary-custom,
            .btn-secondary-custom {
                width: 100%;
                justify-content: center;
            }
        }

        .search-suggestions {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
            border-left: 4px solid var(--color-jaune);
        }

        .search-suggestions h5 {
            color: var(--color-rouge);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .suggestion-links {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .suggestion-links a {
            background: white;
            color: var(--color-rouge);
            padding: 8px 16px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 0.9rem;
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .suggestion-links a:hover {
            background: var(--color-rouge);
            color: white;
            border-color: var(--color-rouge);
        }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-card">
            <!-- Navigation breadcrumb -->
            <div class="breadcrumb-nav">
                <a href="{{ route('user.index') }}">Accueil</a>
                <span class="separator">/</span>
                <span>Page non trouvée</span>
            </div>

            <!-- Icône d'erreur -->
            <div class="error-icon">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>

            <!-- Numéro d'erreur -->
            <h1 class="error-number">404</h1>

            <!-- Titre -->
            <h2 class="error-title">Page non trouvée</h2>

            <!-- Message -->
            <p class="error-message">
                Oups ! La page que vous recherchez n'existe pas ou a été déplacée.
                Ne vous inquiétez pas, nous avons de nombreuses autres pages intéressantes à explorer.
            </p>

            <!-- Actions principales -->
            <div class="error-actions">
                <a href="{{ route('user.index') }}" class="btn-primary-custom">
                    <i class="bi bi-house-fill"></i>
                    Retour à l'accueil
                </a>

                <a href="{{ route('user.boutique') }}" class="btn-secondary-custom">
                    <i class="bi bi-shop"></i>
                    Visiter notre boutique
                </a>
            </div>

            <!-- Suggestions de navigation -->
            <div class="search-suggestions">
                <h5><i class="bi bi-lightbulb-fill me-2"></i>Pages populaires</h5>
                <div class="suggestion-links">
                    <a href="{{ route('user.index') }}">Accueil</a>
                    <a href="{{ route('user.boutique') }}">Boutique</a>
                    <a href="{{ route('panier.index') }}">Mon panier</a>
                </div>
            </div>

            <!-- Message d'aide -->
            <div class="mt-4">
                <p class="text-muted small">
                    <i class="bi bi-info-circle me-1"></i>
                    Si vous pensez qu'il s'agit d'une erreur, n'hésitez pas à nous contacter.
                </p>
            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
