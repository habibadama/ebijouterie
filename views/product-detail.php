<?php
// views/product-detail.php
require_once 'views/header.php';
?>

<div class="container mt-4" style="padding-top: 40px;">
    <!-- Fil d'Ariane -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Accueil</a></li>
            <li class="breadcrumb-item"><a href="index.php?action=catalogue" class="text-decoration-none">Catalogue</a></li>
            <li class="breadcrumb-item active text-dark"><?= htmlspecialchars($product['name']) ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Image du produit -->
        <div class="col-md-6">
            <div class="product-image-container">
                <?php if (!empty($product['image'])): ?>
                    <img src="<?= htmlspecialchars($product['image']) ?>"
                        alt="<?= htmlspecialchars($product['name']) ?>"
                        class="product-main-image">
                <?php else: ?>
                    <div class="product-image-placeholder">
                        <i class="fas fa-gem"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Informations du produit -->
        <div class="col-md-6">
            <div class="product-info-container">
                <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>

                <!-- Catégorie -->
                <div class="product-category mb-3">
                    <span class="category-badge">
                        <i class="fas fa-tag me-2"></i>
                        <?= htmlspecialchars($product['category_name']) ?>
                    </span>
                </div>

                <!-- Prix -->
                <div class="product-price mb-3">
                    <h2 class="price-value"><?= formatPrice($product['price']) ?></h2>
                </div>

                <!-- Description -->
                <div class="product-description mb-3">
                    <h5 class="description-title">Description</h5>
                    <p class="description-text">
                        <?= !empty($product['description']) ?
                            nl2br(htmlspecialchars($product['description'])) :
                            'Ce bijou exceptionnel allie élégance et raffinement.'
                        ?>
                    </p>
                </div>

                <!-- Stock -->
                <div class="product-stock mb-3">
                    <div class="stock-info">
                        <span class="stock-label">Disponibilité :</span>
                        <?php if ($product['stock'] > 0): ?>
                            <span class="stock-badge in-stock">
                                <i class="fas fa-check me-1"></i>
                                En stock (<?= $product['stock'] ?>)
                            </span>
                        <?php else: ?>
                            <span class="stock-badge out-of-stock">
                                <i class="fas fa-times me-1"></i>
                                Rupture de stock
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Formulaire d'achat -->
                <div class="purchase-form mb-3">
                    <form method="POST" action="index.php?action=add-to-cart">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="quantity" class="form-label">Quantité</label>
                                <select class="form-select quantity-select" id="quantity" name="quantity"
                                    <?= $product['stock'] == 0 || isAdmin() ? 'disabled' : '' ?>>
                                    <!-- Utiliser $quantityOptions préparé par le contrôleur -->
                                    <?php foreach ($quantityOptions as $quantity): ?>
                                        <option value="<?= $quantity ?>"><?= $quantity ?></option>
                                    <?php endforeach; ?>
                                    <?php if ($product['stock'] == 0): ?>
                                        <option value="0">0</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col">
                                <?php if ($product['stock'] > 0 && !isAdmin()): ?>
                                    <button type="submit" class="btn btn-add-to-cart">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        Ajouter au panier
                                    </button>
                                <?php elseif (isAdmin()): ?>
                                    <button type="button" class="btn btn-disabled" disabled>
                                        <i class="fas fa-user-shield me-2"></i>
                                        Admin - Achat désactivé
                                    </button>
                                <?php else: ?>
                                    <button type="button" class="btn btn-disabled" disabled>
                                        <i class="fas fa-bell me-2"></i>
                                        Produit indisponible
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Actions -->
                <div class="product-actions">
                    <button class="btn btn-action btn-favorite">
                        <i class="far fa-heart me-1"></i> Favoris
                    </button>
                    <button class="btn btn-action btn-share">
                        <i class="fas fa-share-alt me-1"></i> Partager
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Section produits similaires -->
    <?php if (!empty($relatedProducts)): ?>
        <div class="related-products mt-4">
            <div class="row">
                <div class="col-12">
                    <h3 class="related-title">Produits similaires</h3>
                    <div class="row">
                        <?php foreach ($relatedProducts as $relatedProduct): ?>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <div class="related-product-card">
                                    <div class="card-image">
                                        <?php if (!empty($relatedProduct['image'])): ?>
                                            <img src="<?= htmlspecialchars($relatedProduct['image']) ?>"
                                                alt="<?= htmlspecialchars($relatedProduct['name']) ?>"
                                                class="product-image">
                                        <?php else: ?>
                                            <div class="image-placeholder">
                                                <i class="fas fa-gem"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="index.php?action=product&id=<?= $relatedProduct['id'] ?>"
                                                class="product-link">
                                                <?= htmlspecialchars($relatedProduct['name']) ?>
                                            </a>
                                        </h5>
                                        <p class="card-category"><?= htmlspecialchars($relatedProduct['category_name']) ?></p>
                                        <div class="card-footer">
                                            <div class="price-action">
                                                <span class="price"><?= formatPrice($relatedProduct['price']) ?></span>
                                                <a href="index.php?action=product&id=<?= $relatedProduct['id'] ?>"
                                                    class="btn-view">
                                                    Voir
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Variables - PLUS SPÉCIFIQUES */
    .product-detail-page {
        --primary-color: #2c3e50;
        --secondary-color: #34495e;
        --accent-color: #e74c3c;
        --success-color: #27ae60;
        --warning-color: #f39c12;
        --light-bg: #f8f9fa;
        --border-color: #e9ecef;
        --text-dark: #2c3e50;
        --text-muted: #6c757d;
        --border-radius: 8px;
        --shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        --transition: all 0.3s ease;
    }

    /* Layout général - PLUS SPÉCIFIQUE */
    .container.product-detail-container {
        max-width: 1200px;
        min-height: auto;
    }

    /* Fil d'Ariane - PLUS SPÉCIFIQUE */
    .product-detail-page .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 1.5rem;
    }

    .product-detail-page .breadcrumb-item a {
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .product-detail-page .breadcrumb-item a:hover {
        color: #2c3e50;
    }

    .product-detail-page .breadcrumb-item.active {
        color: #2c3e50;
        font-weight: 500;
    }

    /* Image du produit */
    .product-image-container {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }

    .product-main-image {
        width: 100%;
        height: 350px;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .product-main-image:hover {
        transform: scale(1.02);
    }

    .product-image-placeholder {
        width: 100%;
        height: 350px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 3rem;
    }

    /* Informations produit */
    .product-info-container {
        padding: 0 0.5rem;
    }

    .product-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .product-category {
        margin-bottom: 1rem;
    }

    .category-badge {
        background: rgba(52, 152, 219, 0.1);
        color: #3498db;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Prix */
    .price-value {
        font-size: 2rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0;
    }

    /* Description */
    .description-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.75rem;
    }

    .description-text {
        color: #6c757d;
        line-height: 1.6;
        font-size: 1rem;
        margin-bottom: 0;
    }

    /* Stock */
    .stock-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .stock-label {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.95rem;
    }

    .stock-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .in-stock {
        background: rgba(39, 174, 96, 0.1);
        color: #27ae60;
    }

    .out-of-stock {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }

    /* Formulaire d'achat */
    .purchase-form {
        background: #f8f9fa;
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .form-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
    }

    .quantity-select {
        border: 2px solid #e9ecef;
        border-radius: 6px;
        padding: 0.6rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .quantity-select:focus {
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.2rem rgba(44, 62, 80, 0.1);
    }

    .btn-add-to-cart {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
    }

    .btn-add-to-cart:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(44, 62, 80, 0.3);
    }

    .btn-disabled {
        background: #6c757d;
        color: white;
        border: none;
        padding: 0.8rem 1.5rem;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 600;
        width: 100%;
        opacity: 0.7;
    }

    /* Actions - MODIFICATION : Toujours côte à côte */
    .product-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-action {
        flex: 1;
        padding: 0.6rem 1.2rem;
        border: 2px solid #e9ecef;
        border-radius: 6px;
        background: white;
        color: #2c3e50;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        border-color: #2c3e50;
        color: #2c3e50;
        transform: translateY(-1px);
    }

    /* Produits similaires */
    .related-products {
        padding-top: 2rem;
        border-top: 1px solid #e9ecef;
    }

    .related-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 1.5rem;
    }

    .related-product-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }

    .related-product-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-image {
        height: 180px;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .related-product-card:hover .product-image {
        transform: scale(1.05);
    }

    .image-placeholder {
        height: 180px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 1.5rem;
    }

    .card-body {
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        height: calc(100% - 180px);
    }

    .card-title {
        margin-bottom: 0.5rem;
        font-size: 1rem;
    }

    .product-link {
        color: #2c3e50;
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .product-link:hover {
        color: #2c3e50;
        text-decoration: underline;
    }

    .card-category {
        color: #6c757d;
        font-size: 0.85rem;
        margin-bottom: 0.75rem;
    }

    .card-footer {
        margin-top: auto;
    }

    .price-action {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .price {
        font-weight: 700;
        color: #2c3e50;
        font-size: 1.1rem;
    }

    .btn-view {
        background: #2c3e50;
        color: white;
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-view:hover {
        background: #34495e;
        color: white;
        transform: translateY(-1px);
        text-decoration: none;
    }

    /* Responsive - MODIFICATION : Supprimé flex-direction: column pour product-actions */
    @media (max-width: 768px) {
        .product-title {
            font-size: 1.5rem;
        }

        .price-value {
            font-size: 1.75rem;
        }

        .product-main-image,
        .product-image-placeholder {
            height: 300px;
        }

        .stock-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        /* SUPPRIMÉ : .product-actions { flex-direction: column; } */

        .purchase-form .row {
            flex-direction: column;
        }

        .purchase-form .col-auto {
            margin-bottom: 1rem;
        }

        /* Optionnel : ajustement pour très petits écrans */
        @media (max-width: 576px) {
            .product-actions {
                gap: 0.5rem;
            }

            .btn-action {
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
            }
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de la quantité
        const quantitySelect = document.getElementById('quantity');
        if (quantitySelect && !quantitySelect.disabled) {
            quantitySelect.addEventListener('change', function() {
                console.log('Quantité modifiée:', this.value);
            });
        }

        // Partage du produit
        const shareButton = document.querySelector('.btn-share');
        if (shareButton) {
            shareButton.addEventListener('click', function() {
                if (navigator.share) {
                    navigator.share({
                        title: '<?= htmlspecialchars($product['name']) ?>',
                        text: 'Découvrez ce magnifique bijou',
                        url: window.location.href
                    });
                } else {
                    navigator.clipboard.writeText(window.location.href);
                    alert('Lien copié dans le presse-papier !');
                }
            });
        }

        // Favoris
        const favoriteButton = document.querySelector('.btn-favorite');
        if (favoriteButton) {
            favoriteButton.addEventListener('click', function() {
                const icon = this.querySelector('i');
                if (icon.classList.contains('far')) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                    this.style.color = '#e74c3c';
                } else {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                    this.style.color = '';
                }
            });
        }
    });
</script>

<?php require_once 'views/footer.php'; ?>