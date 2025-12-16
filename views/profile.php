<?php
// views/profile.php
require_once 'views/header.php';
?>

<div class="profile-page-container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- En-tête de la page -->
            <div class="profile-header-section mb-5 text-center">
                <div class="profile-avatar-container mb-4">
                    <div class="user-avatar-large">
                        <i class="fas fa-user-circle"></i>
                    </div>
                </div>
                <h1 class="profile-main-title display-5 fw-bold text-dark mb-3">
                    Mon Profil
                </h1>
                <p class="profile-subtitle lead text-muted">Gérez vos informations personnelles et la sécurité de votre compte</p>
            </div>

            <div class="profile-main-card card shadow-lg border-0 overflow-hidden">
                <div class="profile-card-header bg-gradient-primary text-white py-4 position-relative">
                    <div class="header-background-shape"></div>
                    <div class="position-relative z-1 px-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-1 fw-bold">
                                    <i class="fas fa-user me-2"></i>
                                    <?= htmlspecialchars($user->firstname . ' ' . $user->lastname) ?>
                                </h4>
                                <p class="mb-0 opacity-75">
                                    <i class="fas fa-envelope me-1"></i>
                                    <?= htmlspecialchars($user->email) ?>
                                </p>
                            </div>
                            <button class="btn btn-light btn-lg px-4 profile-edit-button" id="editProfileBtn">
                                <i class="fas fa-edit me-2"></i>Modifier
                            </button>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <!-- Messages de notification -->
                    <?php if (isset($success) && $success): ?>
                        <div class="alert alert-success profile-alert alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="alert-icon-container">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="alert-title fw-semibold">Succès</div>
                                    <div class="alert-message small"><?= $success ?></div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error) && $error): ?>
                        <div class="alert alert-danger profile-alert alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="alert-icon-container">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="alert-title fw-semibold">Erreur</div>
                                    <div class="alert-message small"><?= $error ?></div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($passwordSuccess) && $passwordSuccess): ?>
                        <div class="alert alert-success profile-alert alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="alert-icon-container">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="alert-title fw-semibold">Succès</div>
                                    <div class="alert-message small"><?= $passwordSuccess ?></div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($passwordError) && $passwordError): ?>
                        <div class="alert alert-danger profile-alert alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center">
                                <div class="alert-icon-container">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="alert-title fw-semibold">Erreur</div>
                                    <div class="alert-message small"><?= $passwordError ?></div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="row g-4">
                        <!-- Colonne 1: Informations personnelles -->
                        <div class="col-lg-6">
                            <div class="card h-100 border-0 profile-section-card">
                                <div class="card-header profile-section-header bg-primary text-white">
                                    <h5 class="mb-0 fw-bold">
                                        <i class="fas fa-user-edit me-2"></i>
                                        Informations personnelles
                                    </h5>
                                </div>
                                <div class="card-body p-4">
                                    <!-- Mode VISUALISATION -->
                                    <div id="viewMode">
                                        <div class="profile-info-item mb-4">
                                            <div class="info-item-icon">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div class="info-item-content">
                                                <label class="info-item-label">Prénom</label>
                                                <p class="info-item-value"><?= htmlspecialchars($user->firstname) ?></p>
                                            </div>
                                        </div>

                                        <div class="profile-info-item mb-4">
                                            <div class="info-item-icon">
                                                <i class="fas fa-users"></i>
                                            </div>
                                            <div class="info-item-content">
                                                <label class="info-item-label">Nom</label>
                                                <p class="info-item-value"><?= htmlspecialchars($user->lastname) ?></p>
                                            </div>
                                        </div>

                                        <div class="profile-info-item">
                                            <div class="info-item-icon">
                                                <i class="fas fa-envelope"></i>
                                            </div>
                                            <div class="info-item-content">
                                                <label class="info-item-label">Email</label>
                                                <p class="info-item-value"><?= htmlspecialchars($user->email) ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Mode ÉDITION -->
                                    <div id="editMode" class="d-none">
                                        <form method="POST" action="index.php?action=profile" id="profileForm">
                                            <div class="mb-4">
                                                <label for="firstname" class="form-label fw-semibold text-dark">Prénom</label>
                                                <div class="form-input-group">
                                                    <span class="input-group-icon">
                                                        <i class="fas fa-user"></i>
                                                    </span>
                                                    <input type="text" class="form-control-styled" id="firstname" name="firstname"
                                                        value="<?= htmlspecialchars($user->firstname) ?>" required>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="lastname" class="form-label fw-semibold text-dark">Nom</label>
                                                <div class="form-input-group">
                                                    <span class="input-group-icon">
                                                        <i class="fas fa-users"></i>
                                                    </span>
                                                    <input type="text" class="form-control-styled" id="lastname" name="lastname"
                                                        value="<?= htmlspecialchars($user->lastname) ?>" required>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="email" class="form-label fw-semibold text-dark">Email</label>
                                                <div class="form-input-group">
                                                    <span class="input-group-icon">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                    <input type="email" class="form-control-styled" id="email" name="email"
                                                        value="<?= htmlspecialchars($user->email) ?>" required>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-3">
                                                <button type="submit" class="btn btn-success profile-action-button flex-fill">
                                                    <i class="fas fa-check me-2"></i>Enregistrer
                                                </button>
                                                <button type="button" class="btn btn-outline-secondary profile-action-button flex-fill" id="cancelEdit">
                                                    <i class="fas fa-times me-2"></i>Annuler
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Colonne 2: Sécurité et informations du compte -->
                        <div class="col-lg-6">
                            <!-- Sécurité -->
                            <div class="card mb-4 border-0 profile-section-card">
                                <div class="card-header profile-section-header bg-warning text-dark">
                                    <h5 class="mb-0 fw-bold">
                                        <i class="fas fa-lock me-2"></i>
                                        Sécurité du compte
                                    </h5>
                                </div>
                                <div class="card-body p-4">
                                    <form method="POST" action="index.php?action=profile">
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label fw-semibold text-dark">Mot de passe actuel</label>
                                            <div class="form-input-group">
                                                <span class="input-group-icon">
                                                    <i class="fas fa-key"></i>
                                                </span>
                                                <input type="password" class="form-control-styled" id="current_password" name="current_password" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="new_password" class="form-label fw-semibold text-dark">Nouveau mot de passe</label>
                                            <div class="form-input-group">
                                                <span class="input-group-icon">
                                                    <i class="fas fa-lock"></i>
                                                </span>
                                                <input type="password" class="form-control-styled" id="new_password" name="new_password" required>
                                            </div>
                                            <div class="form-help-text">
                                                <i class="fas fa-info-circle me-1"></i>Minimum 6 caractères
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="confirm_password" class="form-label fw-semibold text-dark">Confirmer le mot de passe</label>
                                            <div class="form-input-group">
                                                <span class="input-group-icon">
                                                    <i class="fas fa-check-circle"></i>
                                                </span>
                                                <input type="password" class="form-control-styled" id="confirm_password" name="confirm_password" required>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-warning profile-action-button w-100">
                                            <i class="fas fa-key me-2"></i>Changer le mot de passe
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Informations du compte -->
                            <div class="card border-0 profile-section-card">
                                <div class="card-header profile-section-header bg-info text-white">
                                    <h5 class="mb-0 fw-bold">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Informations du compte
                                    </h5>
                                </div>
                                <div class="card-body p-4">
                                    <div class="profile-info-item mb-3">
                                        <div class="info-item-icon">
                                            <i class="fas fa-user-tag"></i>
                                        </div>
                                        <div class="info-item-content">
                                            <label class="info-item-label">Rôle</label>
                                            <?php if (isAdmin()): ?>
                                                <span class="status-badge badge-warning">
                                                    <i class="fas fa-crown me-1"></i>Administrateur
                                                </span>
                                            <?php else: ?>
                                                <span class="status-badge badge-secondary">
                                                    <i class="fas fa-user me-1"></i>Client
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="profile-info-item mb-3">
                                        <div class="info-item-icon">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                        <div class="info-item-content">
                                            <label class="info-item-label">Date d'inscription</label>
                                            <p class="info-item-value">
                                                <?php
                                                $createdAt = $user->created_at ?? date('Y-m-d H:i:s');
                                                echo date('d-m-Y à H:i:s', strtotime($createdAt));
                                                ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="profile-info-item mb-4">
                                        <div class="info-item-icon">
                                            <i class="fas fa-circle"></i>
                                        </div>
                                        <div class="info-item-content">
                                            <label class="info-item-label">Statut</label>
                                            <span class="status-badge badge-success">
                                                <i class="fas fa-check-circle me-1"></i>Actif
                                            </span>
                                        </div>
                                    </div>

                                    <?php if (isAdmin()): ?>
                                        <div class="border-top pt-3">
                                            <a href="index.php?action=admin" class="btn btn-outline-warning profile-action-button w-100">
                                                <i class="fas fa-crown me-2"></i>Accéder à l'administration
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #34495e;
        --success-color: #27ae60;
        --warning-color: #f39c12;
        --info-color: #3498db;
        --light-bg: #f8f9fa;
        --border-color: #e9ecef;
        --text-dark: #2c3e50;
        --text-muted: #6c757d;
        --border-radius: 12px;
        --border-radius-sm: 8px;
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
        --transition: all 0.3s ease;
    }

    /* Container principal */
    .profile-page-container {
        padding-top: 80px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
    }

    /* En-tête de profil */
    .profile-header-section {
        position: relative;
    }

    .profile-avatar-container {
        display: flex;
        justify-content: center;
    }

    .user-avatar-large {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3rem;
        box-shadow: var(--shadow);
        border: 4px solid white;
    }

    .profile-main-title {
        font-size: 2.5rem;
    }

    .profile-subtitle {
        font-size: 1.25rem;
    }

    /* Carte principale */
    .profile-main-card {
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .profile-main-card:hover {
        box-shadow: var(--shadow-hover);
    }

    /* En-tête de carte */
    .profile-card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) !important;
    }

    .header-background-shape {
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        clip-path: polygon(100% 0, 100% 100%, 0 0);
    }

    /* Sections de profil */
    .profile-section-card {
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        transition: var(--transition);
        overflow: hidden;
    }

    .profile-section-card:hover {
        box-shadow: var(--shadow-hover);
        transform: translateY(-2px);
    }

    .profile-section-header {
        padding: 1.25rem 1.5rem;
        border-bottom: none;
        font-weight: 600;
    }

    /* Boutons */
    .profile-action-button {
        border-radius: var(--border-radius-sm);
        border: none;
        font-weight: 600;
        transition: var(--transition);
        padding: 0.75rem 1.5rem;
    }

    .profile-action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .profile-edit-button:hover {
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
    }

    /* Éléments d'information */
    .profile-info-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .profile-info-item:last-child {
        border-bottom: none;
    }

    .info-item-icon {
        width: 40px;
        height: 40px;
        background: var(--light-bg);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-color);
        font-size: 1rem;
        flex-shrink: 0;
    }

    .info-item-content {
        flex-grow: 1;
    }

    .info-item-label {
        display: block;
        color: var(--text-muted);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .info-item-value {
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 0;
        font-size: 1rem;
    }

    /* Champs de formulaire */
    .form-input-group {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-group-icon {
        position: absolute;
        left: 1rem;
        z-index: 10;
        color: var(--text-muted);
    }

    .form-control-styled {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 2px solid var(--border-color);
        border-radius: var(--border-radius-sm);
        background: white;
        transition: var(--transition);
        font-size: 1rem;
    }

    .form-control-styled:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.1);
        outline: none;
    }

    .form-help-text {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-top: 0.5rem;
    }

    /* Badges de statut */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .badge-warning {
        background: rgba(243, 156, 18, 0.1);
        color: var(--warning-color);
    }

    .badge-secondary {
        background: rgba(108, 117, 125, 0.1);
        color: var(--text-muted);
    }

    .badge-success {
        background: rgba(39, 174, 96, 0.1);
        color: var(--success-color);
    }

    /* Alertes */
    .profile-alert {
        border: none;
        border-radius: var(--border-radius-sm);
        box-shadow: var(--shadow);
    }

    .alert-icon-container {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 1.25rem;
    }

    .alert-title {
        font-size: 1rem;
    }

    .alert-message {
        font-size: 0.875rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-page-container {
            padding-top: 60px;
        }

        .user-avatar-large {
            width: 80px;
            height: 80px;
            font-size: 2.5rem;
        }

        .card-body {
            padding: 1.5rem !important;
        }

        .profile-info-item {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .info-item-icon {
            align-self: center;
        }

        .profile-action-button {
            padding: 0.6rem 1.25rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .profile-section-header h5 {
            font-size: 1rem;
        }

        .profile-main-title {
            font-size: 2rem;
        }

        .profile-edit-button {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editProfileBtn = document.getElementById('editProfileBtn');
        const cancelEdit = document.getElementById('cancelEdit');
        const viewMode = document.getElementById('viewMode');
        const editMode = document.getElementById('editMode');

        editProfileBtn.addEventListener('click', function() {
            viewMode.classList.add('d-none');
            editMode.classList.remove('d-none');
            this.classList.add('d-none');
        });

        cancelEdit.addEventListener('click', function() {
            viewMode.classList.remove('d-none');
            editMode.classList.add('d-none');
            editProfileBtn.classList.remove('d-none');
        });
    });
</script>

<?php require_once 'views/footer.php'; ?>