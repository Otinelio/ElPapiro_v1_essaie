@extends('layouts.admin')

@section('title')
    Gestion du Personnel
@endsection

@section('personnels')
    collapsed
@endsection

@section('section')
    <div class="container-fluid px-4">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-users me-1"></i>
                    Liste des Personnels
                </div>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#addPersonnelModal">
                    <i class="fas fa-plus"></i> Ajouter un membre
                </button>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Date d'ajout</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($personnels as $personnel)
                            <tr>
                                <td>
                                    @if($personnel->id === auth()->id())
                                        <div class="d-flex align-items-center">
                                            {{ $personnel->name }}
                                            <span class="badge bg-secondary ms-2" title="Compte administrateur actuel">
                                                <i class="fas fa-user-shield me-1"></i> Votre compte
                                            </span>
                                        </div>
                                    @else
                                        {{ $personnel->name }}
                                    @endif
                                </td>
                                <td>{{ $personnel->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $personnel->role === 'admin' ? 'danger' : 'info' }}">
                                        {{ ucfirst($personnel->role) }}
                                    </span>
                                </td>
                                <td>{{ $personnel->created_at->format('d/m/Y') }}</td>
                                <td>
                                    @if($personnel->role === 'staff')
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-info btn-sm me-2" data-bs-toggle="modal"
                                                data-bs-target="#editStaffModal{{ $personnel->id }}" title="Modifier">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <form action="{{ route('admin.personnels.destroy', $personnel) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')"
                                                    title="Supprimer">
                                                    <i class="bi bi-archive"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($personnel->id === auth()->id())
                                        <!-- Bouton modifier pour son propre compte admin -->
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#editAdminModal{{ $personnel->id }}" title="Modifier mon compte">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Aucun membre du personnel trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Remplacer la section de gestion du mot de passe par celle-ci -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-key me-1"></i>
                Gestion du mot de passe d'accès administrateur
            </div>
            <div class="card-body">
                @if(session('password_success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('password_success') }}
                    </div>
                @endif

                @error('update_password_error')
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ $message }}
                    </div>
                @enderror

                <form action="{{ route('admin.access.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Mot de passe actuel <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Nouveau mot de passe <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    name="new_password" required minlength="8">
                                @error('new_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Confirmer le nouveau mot de passe <span
                                        class="text-danger">*</span></label>
                                <input type="password"
                                    class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                    name="new_password_confirmation" required minlength="8">
                                @error('new_password_confirmation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Attention :</strong>
                        <ul class="mb-0">
                            <li>Ce mot de passe est utilisé pour accéder à l'interface d'administration.</li>
                            <li>Le mot de passe doit contenir au moins 8 caractères.</li>
                            <li>Assurez-vous de le conserver en lieu sûr.</li>
                        </ul>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        Mettre à jour le mot de passe d'accès
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ajout Personnel -->
    <div class="modal fade" id="addPersonnelModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un membre du personnel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.personnels.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nom complet</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Rôle</label>
                            <select class="form-select" name="role" required>
                                <option value="">Sélectionner un rôle</option>
                                <option value="admin">Administrateur</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modals d'édition pour chaque membre du staff -->
    @foreach($personnels as $personnel)
        @if($personnel->id === auth()->id())
            <div class="modal fade" id="editAdminModal{{ $personnel->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier mon compte</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.personnels.update', $personnel) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i>
                                    Vous modifiez votre compte personnel
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nom complet</label>
                                    <input type="text" class="form-control" name="name" value="{{ $personnel->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $personnel->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nouveau mot de passe</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Laisser vide pour ne pas modifier">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    @foreach($personnels as $personnel)
        @if($personnel->role === 'staff')
            <div class="modal fade" id="editStaffModal{{ $personnel->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Modifier le membre du staff</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.personnels.update', $personnel) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Nom complet</label>
                                    <input type="text" class="form-control" name="name" value="{{ $personnel->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $personnel->email }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Nouveau mot de passe</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Laisser vide pour ne pas modifier">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection