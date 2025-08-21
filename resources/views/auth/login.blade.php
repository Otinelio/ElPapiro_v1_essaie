<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Login</title>
    {{-- <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}

      <!-- Vendor CSS Files -->
  <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">


    <style>
        :root {
            --primary-color: #C70039;
            --secondary-color: #FFC300;
        }
        
        .btn-custom {
            background-color: var(--primary-color);
            border: none;
            color: var(--secondary-color);
        }
        
        .btn-custom:hover {
            background-color: #a30030;
            color: var(--secondary-color);
        }

        .card {
            border: 2px solid var(--primary-color);
        }

        .custom-link {
            color: var(--primary-color);
            text-decoration: none;
        }

        .custom-link:hover {
            color: var(--secondary-color);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(199, 0, 57, 0.25);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        h4 {
            color: var(--primary-color);
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="text-center mb-4">Connexion</h4>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-info">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                <label class="form-check-label" for="remember_me">
                                    {{ __('Remember me') }}
                                </label>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="custom-link">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif
                        
                                <button type="submit" class="btn btn-custom">
                                    {{ __('Log in') }}
                                </button>
                            </div>
                        </form>
                        <!-- Lien d'inscription -->
                        <div class="text-center mt-3">
                            <span>Vous n'avez pas de compte ?</span>
                            <a href="{{ route('register') }}" class="custom-link" style="color: var(--secondary-color);">
                                <strong>{{ __('Register') }}</strong>
                            </a>
                        </div>
                    </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
        <!-- Vendor JS Files -->
        <script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>