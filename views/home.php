<!-- Hero Section Redesign -->
<section class="hero-section-v2">
    <img src="assets/images/banner-img.avif" alt="Bannière principale" class="hero-background-img">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-8 text-center">
                <div class="hero-content">
                    <h1 class="hero-title-v2">L'Art de la Bijouterie Réinventé</h1>
                    <p class="hero-subtitle-v2">Découvrez des créations uniques où tradition et modernité se rencontrent pour sublimer votre élégance.</p>
                    <div class="hero-actions-v2">
                        <a href="index.php?action=catalogue" class="btn btn-gold btn-lg">
                            <i class="fas fa-gem me-2"></i>Découvrir la Collection
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Catégories Redesign -->
<section class="categories-section-v2 py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title-v2">Nos Univers</h2>
            <p class="section-subtitle">Explorez nos collections par catégorie</p>
        </div>
        <div class="row g-4">
            <?php foreach ($categories as $category): ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="index.php?action=catalogue&category=<?= $category['id'] ?>" class="category-card-v2">
                        <div class="category-image-v2">
                            <?php
                            $categoryImages = [
                                'Bagues' => 'assets/images/category/bagues.webp',
                                'Boucles d\'oreilles' => 'assets/images/category/boucles_oreilles.webp',
                                'Bracelets' => 'assets/images/category/bracelets.webp',
                                'Colliers' => 'assets/images/category/colliers.jpg',
                                'Médailles' => 'assets/images/category/medailles.webp',
                                'Pendentifs' => 'assets/images/category/pendentifs.webp',
                                'Sautoirs' => 'assets/images/category/sautoirs.webp',
                            ];

                            $imageSrc = $categoryImages[$category['name']] ?? 'assets/images/category/default.jpg';
                            ?>
                            <img src="<?= $imageSrc ?>"
                                alt="Collection <?= htmlspecialchars($category['name']) ?>"
                                class="category-img"
                                loading="lazy"
                                onerror="this.src='assets/images/categories/default.jpg'">
                            <div class="category-image-overlay"></div>
                        </div>
                        <div class="category-content">
                            <h5 class="category-name-v2"><?= htmlspecialchars($category['name']) ?></h5>
                            <p class="category-count-v2"><?= $categoryCounts[$category['id']] ?? 0 ?> produits</p>
                        </div>
                        <div class="category-hover">
                            <span>Voir la collection</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Produits en vedette Redesign -->
<section id="featured" class="featured-section-v2 py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title-v2">Nos Créations Exclusives</h2>
            <p class="section-subtitle">Des pièces uniques sélectionnées avec soin</p>
        </div>
        <div class="row g-4">
            <?php foreach (array_slice($products, 0, 4) as $product): ?>
                <div class="col-xl-3 col-lg-6">
                    <div class="product-card-v2">
                        <div class="product-image-v2">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= htmlspecialchars($product['image']) ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                    class="img-fluid">
                                <div class="product-overlay">
                                    <div class="product-actions-v2">
                                        <button class="action-btn-v2 quick-view" title="Voir rapidement" onclick="window.location.href='index.php?action=product&id=<?= $product['id'] ?>'">
                                            <i class="fas fa-eye"></i>
                                            <span class="action-tooltip">Voir détails</span>
                                        </button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="no-image-v2">
                                    <i class="fas fa-gem"></i>
                                    <span class="no-image-text">Image non disponible</span>
                                </div>
                            <?php endif; ?>
                            <div class="product-badge-v2">Nouveau</div>
                            <?php if ($product['price'] < 100): ?>
                                <div class="product-badge-v2 discount">-20%</div>
                            <?php endif; ?>
                        </div>
                        <div class="product-info-v2">
                            <div class="product-meta">
                                <span class="product-category-v2"><?= htmlspecialchars($product['category_name'] ?? 'Non catégorisé') ?></span>
                            </div>
                            <h5 class="product-name-v2">
                                <a href="index.php?action=product&id=<?= $product['id'] ?>" class="text-decoration-none">
                                    <?= htmlspecialchars($product['name']) ?>
                                </a>
                            </h5>
                            <div class="product-price-section">
                                <div class="product-price-v2"><?= formatPrice($product['price']) ?></div>
                                <?php if ($product['price'] < 100): ?>
                                    <div class="product-old-price"><?= formatPrice($product['price'] * 1.25) ?></div>
                                <?php endif; ?>
                            </div>
                            <form method="POST" action="index.php?action=add-to-cart" class="mt-3">
                                <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="quantity" value="1">

                                <?php if (isAdmin()): ?>
                                    <div class="text-center">
                                        <button class="btn btn-outline-secondary rounded-pill px-3" disabled>
                                            <i class="fas fa-user-shield me-2"></i>Admin
                                        </button>
                                        <small class="text-muted d-block mt-1">Achat désactivé</small>
                                    </div>
                                <?php else: ?>
                                    <button type="submit" class="btn btn-gold btn-sm w-100 add-to-cart-btn">
                                        <i class="fas fa-shopping-bag me-2"></i>Ajouter au panier
                                        <div class="btn-loader"></div>
                                    </button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5">
            <a href="index.php?action=catalogue" class="btn btn-gold-outline btn-lg">
                <i class="fas fa-store me-2"></i>Explorer Tout le Catalogue
            </a>
        </div>
    </div>
</section>
<section class="values-section-v2 py-5">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title-v2">Notre Engagement</h2>
            <p class="section-subtitle">L'excellence au service de votre élégance</p>
        </div>
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="value-card-v2">
                    <div class="value-icon-v2">
                        <i class="fas fa-gem"></i>
                    </div>
                    <h4>Qualité Exceptionnelle</h4>
                    <p>Des matériaux nobles et un savoir-faire artisanal pour des bijoux durables dans le temps</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="value-card-v2">
                    <div class="value-icon-v2">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h4>Livraison Rapide</h4>
                    <p>Expédition sous 48h et livraison gratuite à partir de 100€ d'achat partout en France</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="value-card-v2">
                    <div class="value-icon-v2">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <h4>Service Personnalisé</h4>
                    <p>Conseils experts et service client dédié 7j/7 pour répondre à toutes vos questions</p>
                </div>
            </div>
        </div>
    </div>
</section>



<?php require_once 'views/footer.php'; ?>