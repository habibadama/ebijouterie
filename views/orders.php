<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-shopping-cart me-2"></i>
        Gestion des Commandes
    </h1>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                                <p class="text-muted">Aucune commande trouvée</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td class="fw-bold">#<?= $order['id'] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($order['firstname'] . ' ' . $order['lastname']) ?></strong>
                                    <br>
                                    <small class="text-muted"><?= htmlspecialchars($order['email']) ?></small>
                                </td>
                                <td>
                                    <small class="text-muted d-block">
                                        <?= date('d/m/Y', strtotime($order['created_at'])) ?>
                                    </small>
                                    <small class="text-muted">
                                        <?= date('H:i', strtotime($order['created_at'])) ?>
                                    </small>
                                </td>
                                <td class="fw-bold text-success"><?= formatPrice($order['total_price']) ?></td>
                                <td>
                                    <span class="badge bg-<?=
                                                            $order['status'] == 'completed' ? 'success' : ($order['status'] == 'pending' ? 'warning' : ($order['status'] == 'shipped' ? 'info' : 'secondary'))
                                                            ?> rounded-pill">
                                        <?= ucfirst($order['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <!-- Voir détails -->
                                        <a href="index.php?action=admin-order-detail&id=<?= $order['id'] ?>"
                                            class="btn btn-outline-primary" title="Voir détails">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Modifier statut -->
                                        <a href="index.php?action=admin-edit-order&id=<?= $order['id'] ?>"
                                            class="btn btn-outline-success" title="Modifier statut">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>