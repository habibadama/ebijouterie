<div class="container-fluid px-4 mt-4">
    <!-- En-tête élégant -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="fas fa-users fa-lg text-primary"></i>
                </div>
                <div>
                    <h1 class="h3 fw-bold text-dark mb-1">Gestion des Utilisateurs</h1>
                    <p class="text-muted mb-0"><?= count($users) ?> utilisateur(s) inscrit(s)</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-end">
                <div class="search-container position-relative">
                    <i class="fas fa-search position-absolute top-50 start-3 translate-middle-y text-muted"></i>
                    <input type="text" class="form-control ps-5" placeholder="Rechercher un utilisateur..." id="searchUsers" style="min-width: 250px;">
                </div>
            </div>
        </div>
    </div>

    <!-- Carte principale avec tableau -->
    <div class="card border-0 shadow-lg rounded-3 overflow-hidden">
        <div class="card-header bg-white border-0 py-4">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="card-title mb-0 fw-semibold text-dark">
                        <i class="fas fa-list-check me-2 text-primary"></i>
                        Liste des utilisateurs
                    </h5>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light bg-opacity-50">
                        <tr>
                            <th class="border-0 ps-4 fw-semibold text-uppercase text-muted small" style="letter-spacing: 0.5px;">Utilisateur</th>
                            <th class="border-0 fw-semibold text-uppercase text-muted small" style="letter-spacing: 0.5px;">Email</th>
                            <th class="border-0 fw-semibold text-uppercase text-muted small" style="letter-spacing: 0.5px;">Rôle</th>
                            <th class="border-0 fw-semibold text-uppercase text-muted small" style="letter-spacing: 0.5px;">Inscription</th>
                            <th class="border-0 text-end pe-4 fw-semibold text-uppercase text-muted small" style="letter-spacing: 0.5px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($users)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="py-4">
                                        <div class="empty-state-icon mb-3">
                                            <i class="fas fa-users fa-3x text-muted opacity-25"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mb-2">Aucun utilisateur trouvé</h5>
                                        <p class="text-muted mb-0">Les utilisateurs apparaîtront ici une fois inscrits.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($users as $user): ?>
                                <?php
                                $roles = json_decode($user['roles'], true) ?? [];
                                $isAdmin = in_array('ROLE_ADMIN', $roles);
                                ?>
                                <tr class="user-item">
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-wrapper position-relative me-3">
                                                <div class="avatar bg-<?= $isAdmin ? 'warning' : 'primary' ?> text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                    style="width: 48px; height: 48px; font-weight: 700; font-size: 1.1rem;">
                                                    <?= strtoupper(substr($user['firstname'], 0, 1) . substr($user['lastname'], 0, 1)) ?>
                                                </div>
                                                <?php if ($isAdmin): ?>
                                                    <div class="position-absolute bottom-0 end-0 bg-warning border border-2 border-white rounded-circle" style="width: 14px; height: 14px;"></div>
                                                <?php endif; ?>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark mb-1"><?= htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) ?></div>
                                                <small class="text-muted">
                                                    <i class="fas fa-hashtag me-1"></i>#<?= $user['id'] ?>
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <div class="text-dark mb-1"><?= htmlspecialchars($user['email']) ?></div>
                                        <small class="text-muted">
                                            <i class="fas fa-<?= $isAdmin ? 'user-shield' : 'user' ?> me-1"></i>
                                            <?= $isAdmin ? 'Compte administrateur' : 'Compte client' ?>
                                        </small>
                                    </td>
                                    <td class="py-3">
                                        <span class="badge rounded-pill px-3 py-2 fw-semibold <?= $isAdmin ? 'bg-warning text-dark' : 'bg-primary text-white' ?> shadow-sm">
                                            <i class="fas <?= $isAdmin ? 'fa-crown' : 'fa-user' ?> me-1"></i>
                                            <?= $isAdmin ? 'Administrateur' : 'Client' ?>
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <div class="fw-semibold text-dark"><?= date('d/m/Y', strtotime($user['created_at'])) ?></div>
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            <?= date('H:i', strtotime($user['created_at'])) ?>
                                        </small>
                                    </td>
                                    <td class="text-end pe-4 py-3">
                                        <div class="btn-group btn-group-sm shadow-sm">
                                            <button class="btn btn-outline-primary rounded-start-2 px-3"
                                                title="Voir le profil"
                                                data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-warning px-3"
                                                title="Modifier le rôle"
                                                data-bs-toggle="tooltip">
                                                <i class="fas fa-user-cog"></i>
                                            </button>
                                            <?php if (!$isAdmin): ?>
                                                <button class="btn btn-outline-danger rounded-end-2 px-3"
                                                    title="Supprimer l'utilisateur"
                                                    data-bs-toggle="tooltip">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            <?php else: ?>
                                                <button class="btn btn-outline-secondary rounded-end-2 px-3" disabled>
                                                    <i class="fas fa-lock"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer avec pagination -->
        <div class="card-footer bg-white border-0 py-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Affichage de <strong><?= count($users) ?></strong> utilisateur(s)
                    </p>
                </div>
                <div class="col-md-6">
                    <nav class="d-flex justify-content-end">
                        <ul class="pagination pagination-sm mb-0 shadow-sm">
                            <li class="page-item disabled">
                                <a class="page-link border-0 rounded-start-2" href="#">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link border-0" href="#">1</a></li>
                            <li class="page-item"><a class="page-link border-0" href="#">2</a></li>
                            <li class="page-item"><a class="page-link border-0" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link border-0 rounded-end-2" href="#">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styles élégants */
    .card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .icon-wrapper {
        transition: transform 0.3s ease;
    }

    .icon-wrapper:hover {
        transform: scale(1.1);
    }

    .avatar {
        transition: all 0.3s ease;
    }

    .user-item:hover .avatar {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
    }

    .table-hover tbody tr {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa !important;
        border-left: 3px solid #4361ee;
        transform: translateX(4px);
    }

    .btn-group .btn {
        transition: all 0.3s ease;
        border-width: 1.5px;
    }

    .btn-group .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .search-container input {
        border: 1.5px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .search-container input:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
    }

    .empty-state-icon {
        transition: transform 0.3s ease;
    }

    .empty-state-icon:hover {
        transform: scale(1.1);
    }

    /* Badges améliorés */
    .badge.bg-primary {
        background: linear-gradient(135deg, #4361ee, #3a56d4) !important;
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107, #ffb300) !important;
    }

    /* Pagination améliorée */
    .pagination .page-link {
        transition: all 0.3s ease;
        margin: 0 2px;
    }

    .pagination .page-link:hover {
        transform: translateY(-1px);
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        border-color: #4361ee;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem;
        }

        .search-container input {
            min-width: 100% !important;
        }

        .avatar {
            width: 40px !important;
            height: 40px !important;
            font-size: 0.9rem !important;
        }

        .btn-group .btn {
            padding: 0.375rem 0.75rem;
        }
    }
</style>