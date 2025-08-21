<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Administrateur | El Papiro</title>

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

        .access-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .access-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            text-align: center;
            max-width: 500px;
            width: 100%;
            border: 3px solid var(--primary-color);
        }

        .access-icon {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .access-title {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .access-message {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(199, 0, 57, 0.25);
        }

        .btn-custom {
            background-color: var(--primary-color);
            border: none;
            color: var(--secondary-color);
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #a30030;
            color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 15px;
            border: none;
        }
    </style>
</head>

<body>
    <div class="access-container">
        <div class="access-card">
            <div class="access-icon">
                <i class="bi bi-shield-lock-fill"></i>
            </div>

            <h2 class="access-title">Accès Administrateur</h2>

            <p class="access-message">
                Cette section est réservée au personnel administratif d'El Papiro.
                Veuillez saisir le mot de passe d'accès pour continuer.
            </p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.access.verify') }}">
                @csrf

                <div class="mb-4">
                    <label for="admin_password" class="form-label fw-semibold">Mot de passe administrateur</label>
                    <input type="password"
                        class="form-control form-control-lg @error('admin_password') is-invalid @enderror"
                        id="admin_password" name="admin_password" required autofocus
                        placeholder="Saisissez le mot de passe">
                </div>

                <button type="submit" class="btn btn-custom btn-lg">
                    <i class="bi bi-unlock-fill me-2"></i>
                    Accéder
                </button>
            </form>

            <div class="mt-4">
                <a href="{{ route('user.index') }}" class="text-muted text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
