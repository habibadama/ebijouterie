<div class="container-fluid py-4" style="padding-top: 80px;">
    <div class="container">
        <!-- Header avec navigation -->
        <div class="order-detail-header mb-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="order-header-icon me-3">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <h1 class="h3 fw-bold text-dark mb-1">Détails de la commande</h1>
                            <p class="text-muted mb-0">#<?= $order['id'] ?> • Gestion complète de la commande</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="index.php?action=admin-edit-order&id=<?= $order['id'] ?>" class="btn btn-primary btn-action">
                        <i class="fas fa-edit me-2"></i>Modifier le statut
                    </a>
                    <a href="index.php?action=admin-orders" class="btn btn-outline-secondary btn-action">
                        <i class="fas fa-arrow-left me-2"></i>Retour aux commandes
                    </a>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Colonne principale -->
            <div class="col-lg-8">
                <!-- Carte des articles commandés -->
                <div class="card order-items-card shadow-sm border-0 mb-4">
                    <div class="card-header order-items-card-header bg-white">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-boxes me-2 text-warning"></i>
                            Articles commandés
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table order-items-table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold ps-4">Produit</th>
                                        <th class="fw-semibold text-center">Prix unitaire</th>
                                        <th class="fw-semibold text-center">Quantité</th>
                                        <th class="fw-semibold text-end pe-4">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($items as $item): ?>
                                        <tr class="order-item-row">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center gap-3">
                                                    <?php if (!empty($item['image'])): ?>
                                                        <div class="order-item-image">
                                                            <img src="<?= htmlspecialchars($item['image']) ?>"
                                                                alt="<?= htmlspecialchars($item['name']) ?>"
                                                                class="img-fluid">
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="order-item-image-placeholder">
                                                            <i class="fas fa-gem"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <h6 class="mb-1 fw-semibold"><?= htmlspecialchars($item['name']) ?></h6>
                                                        <small class="text-muted">Ref: #<?= $item['id'] ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-semibold text-dark"><?= formatPrice($item['price']) ?></span>
                                            </td>
                                            <td class="text-center">
                                                <span class="order-quantity-badge"><?= $item['quantity'] ?></span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <span class="fw-bold text-success"><?= formatPrice($item['price'] * $item['quantity']) ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot class="table-success">
                                    <tr>
                                        <td colspan="3" class="text-end fw-bold ps-4">
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                <i class="fas fa-receipt text-success"></i>
                                                <span>Total commande :</span>
                                            </div>
                                        </td>
                                        <td class="text-end pe-4">
                                            <span class="h5 fw-bold text-success mb-0"><?= formatPrice($order['total_price']) ?></span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Timeline de statut -->
                <div class="card order-timeline-card shadow-sm border-0">
                    <div class="card-header order-timeline-card-header bg-white">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-history me-2 text-info"></i>
                            Historique du statut
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="order-status-timeline">
                            <div class="timeline-step <?= $order['status'] == 'pending' ? 'active' : 'completed' ?>">
                                <div class="timeline-step-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="timeline-step-content">
                                    <h6 class="fw-semibold mb-1">En attente</h6>
                                    <p class="text-muted small mb-0">Commande reçue, en attente de traitement</p>
                                </div>
                            </div>
                            <div class="timeline-step <?= $order['status'] == 'confirmed' ? 'active' : ($order['status'] == 'shipped' || $order['status'] == 'completed' ? 'completed' : '') ?>">
                                <div class="timeline-step-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="timeline-step-content">
                                    <h6 class="fw-semibold mb-1">Confirmée</h6>
                                    <p class="text-muted small mb-0">Commande validée et en préparation</p>
                                </div>
                            </div>
                            <div class="timeline-step <?= $order['status'] == 'shipped' ? 'active' : ($order['status'] == 'completed' ? 'completed' : '') ?>">
                                <div class="timeline-step-icon">
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                                <div class="timeline-step-content">
                                    <h6 class="fw-semibold mb-1">Expédiée</h6>
                                    <p class="text-muted small mb-0">Commande envoyée au client</p>
                                </div>
                            </div>
                            <div class="timeline-step <?= $order['status'] == 'completed' ? 'active' : '' ?>">
                                <div class="timeline-step-icon">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                                <div class="timeline-step-content">
                                    <h6 class="fw-semibold mb-1">Livrée</h6>
                                    <p class="text-muted small mb-0">Commande livrée avec succès</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar informations -->
            <div class="col-lg-4">
                <!-- Carte informations commande -->
                <div class="card order-info-card shadow-sm border-0 mb-4">
                    <div class="card-header order-info-card-header bg-primary text-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-info-circle me-2"></i>
                            Informations commande
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="order-info-item mb-3">
                            <div class="order-info-icon">
                                <i class="fas fa-hashtag"></i>
                            </div>
                            <div class="order-info-content">
                                <label class="order-info-label">Numéro</label>
                                <p class="order-info-value">#<?= $order['id'] ?></p>
                            </div>
                        </div>
                        <div class="order-info-item mb-3">
                            <div class="order-info-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="order-info-content">
                                <label class="order-info-label">Date</label>
                                <p class="order-info-value"><?= date('d/m/Y à H:i', strtotime($order['created_at'])) ?></p>
                            </div>
                        </div>
                        <div class="order-info-item mb-4">
                            <div class="order-info-icon">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div class="order-info-content">
                                <label class="order-info-label">Statut</label>
                                <div class="order-status-badge order-status-<?= $order['status'] ?>">
                                    <i class="fas fa-<?=
                                                        $order['status'] == 'completed' ? 'check' : ($order['status'] == 'pending' ? 'clock' : ($order['status'] == 'shipped' ? 'shipping-fast' : 'info-circle'))
                                                        ?> me-1"></i>
                                    <?= ucfirst($order['status']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte informations client -->
                <div class="card customer-info-card shadow-sm border-0">
                    <div class="card-header customer-info-card-header bg-success text-white">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-user me-2"></i>
                            Informations client
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="order-info-item mb-3">
                            <div class="order-info-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="order-info-content">
                                <label class="order-info-label">Client</label>
                                <p class="order-info-value"><?= htmlspecialchars($order['firstname'] . ' ' . $order['lastname']) ?></p>
                            </div>
                        </div>
                        <div class="order-info-item mb-3">
                            <div class="order-info-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="order-info-content">
                                <label class="order-info-label">Email</label>
                                <p class="order-info-value text-break"><?= htmlspecialchars($order['email']) ?></p>
                            </div>
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-icon">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <div class="order-info-content">
                                <label class="order-info-label">ID Client</label>
                                <p class="order-info-value">#<?= $order['user_id'] ?></p>
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
        --transition: all 0.3s ease;
    }

    /* Header de la page de commande */
    .order-detail-header {
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 1.5rem;
    }

    .order-header-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-color) 0%, #34495e 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    /* Cartes de commande */
    .order-items-card,
    .order-timeline-card,
    .order-info-card,
    .customer-info-card {
        border-radius: var(--border-radius);
        border: none;
        overflow: hidden;
    }

    .order-items-card-header,
    .order-timeline-card-header,
    .order-info-card-header,
    .customer-info-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        background: white;
    }

    /* Table des articles de commande */
    .order-items-table {
        margin-bottom: 0;
    }

    .order-items-table thead th {
        background: var(--light-bg);
        border-bottom: 2px solid var(--border-color);
        padding: 1rem 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .order-items-table tbody td {
        padding: 1.25rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .order-items-table tbody tr:last-child td {
        border-bottom: none;
    }

    .order-item-row:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }

    /* Images des articles de commande */
    .order-item-image {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
    }

    .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .order-item-image-placeholder {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--light-bg) 0%, #e9ecef 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 1rem;
        flex-shrink: 0;
    }

    /* Badge quantité de commande */
    .order-quantity-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        font-weight: 600;
        font-size: 0.875rem;
    }

    /* Éléments d'information de commande */
    .order-info-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .order-info-item:last-child {
        border-bottom: none;
    }

    .order-info-icon {
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

    .order-info-content {
        flex-grow: 1;
    }

    .order-info-label {
        display: block;
        color: var(--text-muted);
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.25rem;
    }

    .order-info-value {
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 0;
        font-size: 1rem;
    }

    /* Badges de statut de commande */
    .order-status-badge {
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
    }

    .order-status-pending {
        background: rgba(243, 156, 18, 0.1);
        color: var(--warning-color);
    }

    .order-status-completed {
        background: rgba(39, 174, 96, 0.1);
        color: var(--success-color);
    }

    .order-status-shipped {
        background: rgba(52, 152, 219, 0.1);
        color: var(--info-color);
    }

    .order-status-confirmed {
        background: rgba(155, 89, 182, 0.1);
        color: #9b59b6;
    }

    /* Timeline de statut de commande */
    .order-status-timeline {
        position: relative;
        padding: 1rem 0;
    }

    .timeline-step {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 2rem;
        position: relative;
    }

    .timeline-step:last-child {
        margin-bottom: 0;
    }

    .timeline-step::before {
        content: '';
        position: absolute;
        left: 24px;
        top: 40px;
        bottom: -2rem;
        width: 2px;
        background: var(--border-color);
        z-index: 1;
    }

    .timeline-step:last-child::before {
        display: none;
    }

    .timeline-step-icon {
        width: 50px;
        height: 50px;
        background: var(--light-bg);
        border: 2px solid var(--border-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        color: var(--text-muted);
        flex-shrink: 0;
        position: relative;
        z-index: 2;
        transition: var(--transition);
    }

    .timeline-step.completed .timeline-step-icon {
        background: var(--success-color);
        border-color: var(--success-color);
        color: white;
    }

    .timeline-step.active .timeline-step-icon {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    .timeline-step-content {
        flex-grow: 1;
        padding-top: 0.5rem;
    }

    .timeline-step-content h6 {
        margin-bottom: 0.25rem;
    }

    /* Boutons d'action */
    .btn-action {
        border-radius: var(--border-radius-sm);
        border: none;
        font-weight: 600;
        transition: var(--transition);
        padding: 0.75rem 1.5rem;
    }

    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-fluid {
            padding-top: 60px;
        }

        .order-detail-header {
            text-align: center;
        }

        .order-header-icon {
            margin: 0 auto 1rem auto;
        }

        .table-responsive {
            font-size: 0.875rem;
        }

        .order-item-row td {
            padding: 1rem 0.75rem;
        }

        .order-item-image,
        .order-item-image-placeholder {
            width: 40px;
            height: 40px;
        }

        .order-info-item {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .order-info-icon {
            align-self: center;
        }

        .timeline-step {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }

        .timeline-step::before {
            left: 50%;
            transform: translateX(-50%);
        }

        .timeline-step-icon {
            align-self: center;
        }

        .btn-action {
            padding: 0.6rem 1.25rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {

        .order-items-card-header h5,
        .order-timeline-card-header h5,
        .order-info-card-header h5,
        .customer-info-card-header h5 {
            font-size: 1rem;
        }

        .order-items-table thead {
            display: none;
        }

        .order-items-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius-sm);
        }

        .order-items-table tbody td {
            display: block;
            text-align: right;
            padding: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }

        .order-items-table tbody td:last-child {
            border-bottom: none;
        }

        .order-items-table tbody td::before {
            content: attr(data-label);
            float: left;
            font-weight: 600;
            color: var(--text-muted);
        }

        .order-item-row td:first-child {
            text-align: left;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ajouter des labels pour le responsive
        const tableCells = document.querySelectorAll('.order-items-table td');
        const headers = ['Produit', 'Prix unitaire', 'Quantité', 'Total'];

        tableCells.forEach((cell, index) => {
            const headerIndex = index % 4;
            cell.setAttribute('data-label', headers[headerIndex]);
        });

        // Animation d'entrée
        const animateElements = () => {
            const elements = document.querySelectorAll('.order-items-card, .order-timeline-card, .order-info-card, .customer-info-card, .timeline-step');

            elements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = "1";
                    element.style.transform = "translateY(0)";
                }, index * 100);
            });
        };

        // Initialiser les styles d'animation
        const animatedElements = document.querySelectorAll('.order-items-card, .order-timeline-card, .order-info-card, .customer-info-card, .timeline-step');
        animatedElements.forEach(element => {
            element.style.opacity = "0";
            element.style.transform = "translateY(20px)";
            element.style.transition = "opacity 0.6s ease, transform 0.6s ease";
        });

        // Déclencher l'animation
        setTimeout(animateElements, 100);
    });
</script>