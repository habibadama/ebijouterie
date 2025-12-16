<!-- views/my-orders.php -->
<?php require_once 'views/header.php'; ?>

<div class="orders-container">
    <!-- Hero Section -->
    <div class="orders-hero">
        <div class="hero-background"></div>
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-icon">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <h1>Mon Historique d'Achats</h1>
                    <p class="hero-subtitle">Retrouvez toutes vos commandes et suivez vos livraisons</p>
                </div>
            </div>
            <a href="index.php?action=catalogue" class="btn-continue-shopping">
                <i class="fas fa-gem me-2"></i>
                Explorer la collection
            </a>
        </div>
    </div>

    <?php if (empty($orders)): ?>
        <!-- État vide -->
        <div class="empty-orders">
            <div class="empty-container">
                <div class="empty-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h2>Votre histoire commence ici</h2>
                <p class="empty-description">
                    Vous n'avez pas encore de commandes. Découvrez nos créations exclusives
                    et écrivez la première page de votre collection.
                </p>
                <a href="index.php?action=catalogue" class="btn-discover">
                    <i class="fas fa-sparkles me-2"></i>
                    Découvrir les bijoux
                </a>
            </div>
        </div>
    <?php else: ?>
        <!-- Statistiques résumé -->
        <div class="orders-summary">
            <div class="summary-card total">
                <div class="summary-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="summary-content">
                    <!-- Utiliser les données préparées par le contrôleur -->
                    <h3><?= $ordersSummary['total_orders'] ?></h3>
                    <span>Commandes</span>
                </div>
            </div>

            <div class="summary-card amount">
                <div class="summary-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="summary-content">
                    <h3><?= formatPrice($ordersSummary['total_amount']) ?></h3>
                    <span>Total dépensé</span>
                </div>
            </div>

            <div class="summary-card pending">
                <div class="summary-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="summary-content">
                    <h3><?= $ordersSummary['pending_count'] ?></h3>
                    <span>En attente</span>
                </div>
            </div>

            <div class="summary-card completed">
                <div class="summary-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="summary-content">
                    <h3><?= $ordersSummary['completed_count'] ?></h3>
                    <span>Finalisées</span>
                </div>
            </div>
        </div>

        <!-- Liste des commandes -->
        <div class="orders-list">
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <!-- En-tête de la commande -->
                    <div class="order-header">
                        <div class="order-info">
                            <div class="order-number">
                                <i class="fas fa-hashtag"></i>
                                Commande #<?= $order['id'] ?>
                            </div>
                            <div class="order-date">
                                <i class="fas fa-calendar"></i>
                                <?= date('d-m-Y à H:i:s', strtotime($order['created_at'])) ?>
                            </div>
                        </div>
                        <div class="order-status">
                            <span class="status-badge status-<?= $order['status'] ?>">
                                <i class="fas fa-<?=
                                                    $order['status'] == 'completed' ? 'check' : ($order['status'] == 'pending' ? 'clock' : ($order['status'] == 'shipped' ? 'truck' : 'ban'))
                                                    ?>"></i>
                                <?= ucfirst($order['status']) ?>
                            </span>
                        </div>
                    </div>

                    <!-- Articles de la commande -->
                    <div class="order-items">
                        <h4 class="items-title">
                            <i class="fas fa-box-open me-2"></i>
                            Articles commandés
                        </h4>

                        <!-- Utiliser $order['items'] préparé par le contrôleur -->
                        <?php foreach ($order['items'] as $item): ?>
                            <div class="order-item">
                                <div class="item-image">
                                    <?php if (!empty($item['image'])): ?>
                                        <img src="<?= htmlspecialchars($item['image']) ?>"
                                            alt="<?= htmlspecialchars($item['name']) ?>">
                                    <?php else: ?>
                                        <div class="item-placeholder">
                                            <i class="fas fa-gem"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="item-details">
                                    <h5 class="item-name"><?= htmlspecialchars($item['name']) ?></h5>
                                    <p class="item-price"><?= formatPrice($item['price']) ?> / unité</p>
                                </div>

                                <div class="item-quantity">
                                    <span class="quantity-badge">x<?= $item['quantity'] ?></span>
                                </div>

                                <div class="item-total">
                                    <span class="total-price"><?= formatPrice($item['price'] * $item['quantity']) ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Total et actions -->
                    <div class="order-footer">
                        <div class="order-total">
                            <span class="total-label">Total de la commande</span>
                            <span class="total-amount"><?= formatPrice($order['total_price']) ?></span>
                        </div>

                        <div class="order-actions">
                            <?php if ($order['status'] == 'pending'): ?>
                                <!-- Utiliser $order['can_cancel'] préparé par le contrôleur -->
                                <?php if (!empty($order['can_cancel'])): ?>
                                    <a href="index.php?action=cancel-order&id=<?= $order['id'] ?>"
                                        class="btn-action btn-cancel"
                                        onclick="return confirm('Êtes-vous sûr de vouloir annuler la commande #<?= $order['id'] ?> ?')">
                                        <i class="fas fa-times"></i>
                                        Annuler
                                    </a>
                                <?php else: ?>
                                    <span class="action-disabled">
                                        <i class="fas fa-clock"></i>
                                        Délai d'annulation dépassé
                                    </span>
                                <?php endif; ?>

                            <?php elseif ($order['status'] == 'shipped'): ?>
                                <button class="btn-action btn-track">
                                    <i class="fas fa-truck"></i>
                                    Suivre
                                </button>
                            <?php elseif ($order['status'] == 'completed'): ?>
                                <span class="action-completed">
                                    <i class="fas fa-check-circle"></i>
                                    Livrée
                                </span>
                            <?php endif; ?>

                            <a href="index.php?action=order-detail&id=<?= $order['id'] ?>" class="btn-action btn-details">
                                <i class="fas fa-eye"></i>
                                Détails
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des cartes de commande
        const orderCards = document.querySelectorAll('.order-card');

        orderCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = "1";
                card.style.transform = "translateY(0)";
            }, index * 100);
        });

        // Initialiser les styles d'animation
        orderCards.forEach(card => {
            card.style.opacity = "0";
            card.style.transform = "translateY(20px)";
            card.style.transition = "opacity 0.6s ease, transform 0.6s ease";
        });
    });
</script>

<?php require_once 'views/footer.php'; ?>