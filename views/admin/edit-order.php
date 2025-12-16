<div class="container py-5">
    <!-- En-tête -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5">
        <div class="mb-3 mb-md-0">
            <h1 class="h3 fw-bold text-gradient-primary mb-2">
                <i class="fas fa-sync-alt me-2"></i>
                Modifier le statut
            </h1>
            <p class="text-muted mb-0">Commande #<?= htmlspecialchars($order['id']) ?> - Mettez à jour le statut de la commande</p>
        </div>
        <a href="index.php?action=admin-order-detail&id=<?= $order['id'] ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour aux détails
        </a>
    </div>

    <!-- Carte principale -->
    <div class="card order-status-card shadow-lg border-0">
        <div class="card-header order-status-card-header bg-white py-4">
            <h5 class="mb-0 fw-bold text-dark">
                <i class="fas fa-clipboard-list me-2 text-primary"></i>
                Statut de la commande
            </h5>
        </div>
        <div class="card-body p-4 p-md-5">
            <form method="POST" id="orderStatusForm">
                <!-- Sélecteur de statut -->
                <div class="form-field-group mb-4">
                    <label for="status" class="form-label fw-semibold text-dark mb-3">
                        <i class="fas fa-flag me-2 text-warning"></i>
                        Sélectionnez le nouveau statut
                    </label>
                    <div class="status-select-wrapper">
                        <select class="form-input-styled" id="status" name="status" required>
                            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>En attente</option>
                            <option value="confirmed" <?= $order['status'] == 'confirmed' ? 'selected' : '' ?>>Confirmée</option>
                            <option value="shipped" <?= $order['status'] == 'shipped' ? 'selected' : '' ?>>Expédiée</option>
                            <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Livrée</option>
                            <option value="cancelled" <?= $order['status'] == 'cancelled' ? 'selected' : '' ?>>Annulée</option>
                        </select>
                        <div class="select-dropdown-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                </div>

                <!-- Indicateur visuel du statut actuel -->
                <div class="current-status-display mb-4 p-3 rounded">
                    <div class="d-flex align-items-center">
                        <div class="order-status-indicator order-status-<?= htmlspecialchars($order['status']) ?> me-3">
                            <i class="fas fa-info-circle me-1"></i>
                            Statut actuel
                        </div>
                        <span class="fw-semibold text-dark">
                            <?= htmlspecialchars($currentStatusLabel) ?>
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions-section mt-4 pt-4 border-top">
                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-end">
                        <button type="submit" class="btn btn-primary btn-update-status px-4 py-3 flex-fill flex-md-grow-0">
                            <i class="fas fa-save me-2"></i>
                            <span class="fw-semibold">Mettre à jour le statut</span>
                        </button>
                        <a href="index.php?action=admin-order-detail&id=<?= $order['id'] ?>" class="btn btn-outline-secondary px-4 py-3 flex-fill flex-md-grow-0">
                            <i class="fas fa-times me-2"></i>
                            Annuler
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>