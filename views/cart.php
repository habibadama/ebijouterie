<div class="container py-5" style="padding-top: 80px;">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1 class="display-5 fw-bold text-dark">Mon Panier</h1>
                <span class="badge bg-primary fs-6 px-3 py-2">
                    <?= count($cart) ?> article<?= count($cart) > 1 ? 's' : '' ?>
                </span>
            </div>

            <?php if (empty($cart)): ?>
                <!-- Panier vide -->
                <div class="text-center py-5 my-5">
                    <div class="empty-cart-icon mb-4">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-3">Votre panier est vide</h3>
                    <p class="text-muted mb-4 fs-5">Découvrez nos magnifiques bijoux et ajoutez-les à votre panier.</p>
                    <a href="index.php?action=catalogue" class="btn btn-primary btn-lg px-5 py-3">
                        <i class="fas fa-gem me-2"></i>Découvrir nos bijoux
                    </a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <!-- Articles du panier -->
                    <div class="col-lg-8">
                        <div class="cart-items">
                            <?php foreach ($cart as $index => $item): ?>
                                <div class="cart-item-card">
                                    <div class="row align-items-center g-3">
                                        <!-- Image -->
                                        <div class="col-md-2">
                                            <div class="cart-item-image">
                                                <?php if (!empty($item['image'])): ?>
                                                    <img src="<?= htmlspecialchars($item['image']) ?>"
                                                        alt="<?= htmlspecialchars($item['name']) ?>"
                                                        class="img-fluid">
                                                <?php else: ?>
                                                    <div class="image-placeholder">
                                                        <i class="fas fa-gem"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Nom et description -->
                                        <div class="col-md-4">
                                            <div class="cart-item-info">
                                                <h5 class="cart-item-title"><?= htmlspecialchars($item['name']) ?></h5>
                                                <p class="cart-item-category text-muted small mb-0">
                                                    Bijou <?= htmlspecialchars($item['category'] ?? 'luxe') ?>
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Prix unitaire -->
                                        <div class="col-md-2">
                                            <div class="cart-item-price">
                                                <span class="price-unit"><?= formatPrice($item['price']) ?></span>
                                            </div>
                                        </div>

                                        <!-- Quantité -->
                                        <div class="col-md-2">
                                            <div class="cart-item-quantity">
                                                <div class="input-group input-group-sm">
                                                    <button class="btn btn-outline-secondary quantity-btn" type="button" data-action="decrease" data-index="<?= $index ?>">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="number" class="form-control text-center quantity-input"
                                                        value="<?= $item['quantity'] ?>" min="1" max="99"
                                                        data-index="<?= $index ?>" data-price="<?= $item['price'] ?>">
                                                    <button class="btn btn-outline-secondary quantity-btn" type="button" data-action="increase" data-index="<?= $index ?>">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Total et actions -->
                                        <div class="col-md-2">
                                            <div class="cart-item-total text-end">
                                                <div class="total-price fw-bold text-primary mb-2">
                                                    <?= formatPrice($item['price'] * $item['quantity']) ?>
                                                </div>
                                                <a href="index.php?action=remove-from-cart&id=<?= $item['id'] ?>"
                                                    class="btn btn-sm btn-outline-danger remove-btn"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                                    <i class="fas fa-trash me-1"></i>Supprimer
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Résumé de commande -->
                    <div class="col-lg-4">
                        <div class="order-summary-card">
                            <div class="card-header">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-receipt me-2"></i>Résumé de commande
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="summary-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Sous-total</span>
                                    <span class="fw-semibold" id="subtotal"><?= formatPrice($total) ?></span>
                                </div>
                                <div class="summary-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Livraison</span>
                                    <span class="text-success fw-semibold">Gratuite</span>
                                </div>
                                <div class="summary-item d-flex justify-content-between mb-3">
                                    <span class="text-muted">Économies</span>
                                    <span class="text-success fw-semibold">-<?= formatPrice(0) ?></span>
                                </div>

                                <hr class="my-4">

                                <div class="summary-total d-flex justify-content-between align-items-center mb-4">
                                    <strong class="fs-5">Total TTC</strong>
                                    <strong class="fs-4 text-primary" id="total"><?= formatPrice($total) ?></strong>
                                </div>

                                <?php if (isLoggedIn()): ?>
                                    <a href="index.php?action=checkout" class="btn btn-primary btn-lg w-100 py-3 mb-3 checkout-btn">
                                        <i class="fas fa-lock me-2"></i>Procéder au paiement
                                    </a>
                                <?php else: ?>
                                    <div class="alert alert-warning mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <span class="fw-semibold">Connexion requise</span>
                                        </div>
                                        <p class="mb-2 mt-2 small">Vous devez être connecté pour finaliser votre commande</p>
                                        <div class="d-grid gap-2">
                                            <a href="index.php?action=login" class="btn btn-warning btn-sm">
                                                Se connecter
                                            </a>
                                            <a href="index.php?action=register" class="btn btn-outline-dark btn-sm">
                                                Créer un compte
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="security-info text-center mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-shield-alt me-1"></i>
                                        Paiement sécurisé • Livraison gratuite • Retours sous 30 jours
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Continuer les achats -->
                        <div class="continue-shopping mt-4">
                            <a href="index.php?action=catalogue" class="btn btn-outline-dark w-100 py-2">
                                <i class="fas fa-arrow-left me-2"></i>Continuer mes achats
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    /* Variables cart */
    :root {
        --primary-color: #2c3e50;
        --secondary-color: #34495e;
        --accent-color: #e74c3c;
        --success-color: #27ae60;
        --warning-color: #f39c12;
        --light-bg: #f8f9fa;
        --border-color: #e9ecef;
        --text-dark: #2c3e50;
        --text-muted: #6c757d;
        --border-radius: 12px;
        --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    /* Panier vide */
    .empty-cart-icon {
        font-size: 6rem;
        color: #dee2e6;
        margin-bottom: 2rem;
    }

    /* Cart items */
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .cart-item-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        padding: 1.5rem;
        transition: var(--transition);
        border: 1px solid var(--border-color);
    }

    .cart-item-card:hover {
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .cart-item-image {
        border-radius: 8px;
        overflow: hidden;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--light-bg) 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 1.5rem;
        border-radius: 8px;
    }

    .cart-item-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
        font-size: 1.1rem;
    }

    .cart-item-category {
        font-size: 0.85rem;
    }

    .cart-item-price .price-unit {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 1.1rem;
    }

    .cart-item-quantity .input-group {
        width: 120px;
    }

    .cart-item-quantity .btn {
        border-color: var(--border-color);
        padding: 0.375rem 0.75rem;
    }

    .cart-item-quantity .form-control {
        border-color: var(--border-color);
        font-weight: 600;
    }

    .quantity-btn:hover {
        background-color: var(--light-bg);
        border-color: var(--primary-color);
    }

    .total-price {
        font-size: 1.2rem;
    }

    .remove-btn {
        font-size: 0.8rem;
        padding: 0.25rem 0.75rem;
    }

    /* Order summary */
    .order-summary-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        border: 1px solid var(--border-color);
    }

    .order-summary-card .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
    }

    .summary-item {
        font-size: 1rem;
    }

    .summary-total {
        border-top: 2px solid var(--border-color);
        padding-top: 1rem;
    }

    .checkout-btn {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        border: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);
    }

    .security-info {
        border-top: 1px solid var(--border-color);
        padding-top: 1rem;
    }

    /* Continue shopping */
    .continue-shopping .btn {
        transition: var(--transition);
    }

    .continue-shopping .btn:hover {
        background-color: var(--text-dark);
        color: white;
        transform: translateY(-1px);
    }

    /* Badge */
    .badge {
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container {
            padding-top: 60px;
        }

        .cart-item-card {
            padding: 1rem;
        }

        .cart-item-image {
            height: 80px;
            margin-bottom: 1rem;
        }

        .cart-item-title {
            font-size: 1rem;
        }

        .cart-item-quantity .input-group {
            width: 100px;
        }

        .order-summary-card {
            margin-top: 2rem;
        }

        .display-5 {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .cart-item-card .row>div {
            margin-bottom: 1rem;
        }

        .cart-item-total {
            text-align: left !important;
            border-top: 1px solid var(--border-color);
            padding-top: 1rem;
        }
    }
</style>

<script>

</script>