<!-- En-tête du catalogue -->
<section class="catalog-header py-5 bg-gradient-primary">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php" class="text-white-50">Accueil</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">
                            <?= $currentCategory ? htmlspecialchars($currentCategory['name']) : 'Catalogue' ?>
                        </li>
                    </ol>
                </nav>
                <h1 class="display-5 fw-bold text-white mb-3">
                    <?php if ($currentCategory): ?>
                        <i class="fas fa-gem me-3 text-warning"></i>
                        <?= htmlspecialchars($currentCategory['name']) ?>
                    <?php else: ?>
                        <i class="fas fa-crown me-3 text-warning"></i>
                        Notre Collection Exclusive
                    <?php endif; ?>
                </h1>
                <p class="lead text-white-50 mb-0">
                    <?php if ($currentCategory): ?>
                        <?= count($products) ?> pièce(s) exceptionnelle(s) dans cette collection
                    <?php else: ?>
                        Découvrez nos <?= count($products) ?> créations uniques
                    <?php endif; ?>
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
                <?php if (isAdmin()): ?>
                    <a href="index.php?action=admin-products" class="btn btn-warning btn-lg me-2">
                        <i class="fas fa-cog me-2"></i>Administration
                    </a>
                <?php endif; ?>

                <?php if ($currentCategory): ?>
                    <a href="index.php?action=catalogue" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-times me-2"></i>Tout voir
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Catalogue principal -->
<section class="catalog-main py-5">
    <div class="container">
        <div class="row">
            <!-- Sidebar des filtres COMPLÈTE -->
            <div class="col-lg-3 mb-4">
                <div class="filter-sidebar shadow-sm rounded-3">
                    <div class="filter-header bg-light rounded-top py-3 px-4">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-filter me-2 text-primary"></i>
                            Filtres
                        </h5>
                    </div>

                    <div class="filter-body p-4">
                        <!-- Filtre Catégories -->
                        <div class="filter-section mb-4">
                            <h6 class="filter-title fw-semibold mb-3 text-dark">Collections</h6>
                            <div class="filter-group">
                                <!-- Toutes les collections -->
                                <a href="index.php?action=catalogue"
                                    class="filter-item d-block p-3 text-decoration-none text-dark mb-2 rounded <?= !$currentCategory ? 'active-filter' : '' ?>">
                                    <div class="d-flex align-items-center">
                                        <span class="fw-medium">Toutes les collections</span>
                                    </div>
                                </a>

                                <?php foreach ($categories as $category): ?>
                                    <!-- Chaque catégorie -->
                                    <a href="index.php?action=catalogue&category=<?= $category['id'] ?>"
                                        class="filter-item d-block p-3 text-decoration-none text-dark mb-2 rounded <?= $currentCategory && $currentCategory['id'] == $category['id'] ? 'active-filter' : '' ?>">
                                        <div class="d-flex align-items-center">
                                            <span class="fw-medium"><?= htmlspecialchars($category['name']) ?></span>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grille des produits -->
            <div class="col-lg-9">
                <?php if ($currentCategory && !empty($currentCategory['description'])): ?>
                    <div class="category-description alert alert-light border mb-4">
                        <div class="d-flex">
                            <i class="fas fa-info-circle text-primary me-3 mt-1"></i>
                            <div>
                                <h6 class="alert-heading mb-2">À propos de cette collection</h6>
                                <p class="mb-0 text-dark"><?= htmlspecialchars($currentCategory['description']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Barre d'outils avec recherche -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="results-count">
                        <span class="text-muted">Affichage de <strong><?= count($products) ?></strong> produit(s)</span>
                        <?php if (isset($_GET['q']) && !empty($_GET['q'])): ?>
                            <span class="text-primary ms-2">
                                • Recherche : "<strong><?= htmlspecialchars($_GET['q']) ?></strong>"
                            </span>
                            <?php if ($currentCategory): ?>
                                <span class="text-info ms-2">
                                    • Collection : <strong><?= htmlspecialchars($currentCategory['name']) ?></strong>
                                </span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="catalog-search">
                        <form method="GET" action="index.php" class="search-form-enhanced">
                            <input type="hidden" name="action" value="search">

                            <div class="search-container-glass">
                                <input type="text"
                                    class="search-input-enhanced"
                                    name="q"
                                    placeholder="Rechercher un bijou..."
                                    value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                                    required>

                                <button class="btn-search-magnificent" type="submit">
                                    <i class="fas fa-search btn-icon"></i>
                                </button>
                            </div>

                            <?php if (isset($_GET['category'])): ?>
                                <input type="hidden" name="category" value="<?= $_GET['category'] ?>">
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                <div class="row g-4">
                    <?php if (empty($products)): ?>
                        <div class="col-12 text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-search fa-4x text-muted mb-4"></i>
                                <h4 class="text-dark mb-3">Aucun produit trouvé</h4>
                                <p class="text-muted mb-4">
                                    <?php if ($currentCategory): ?>
                                        Nous n'avons trouvé aucun produit dans cette collection pour le moment.
                                    <?php else: ?>
                                        Notre collection est en cours de préparation.
                                    <?php endif; ?>
                                </p>
                                <?php if ($currentCategory): ?>
                                    <a href="index.php?action=catalogue" class="btn btn-primary btn-lg">
                                        <i class="fas fa-arrow-left me-2"></i>Explorer toutes les collections
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-xl-4 col-lg-4 col-md-6">
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
                    <?php endif; ?>
                </div>

                <!-- Pagination -->
                <nav class="mt-5" aria-label="Navigation des pages">
                    <ul class="pagination justify-content-center">
                        <!-- Bouton Précédent -->
                        <li class="page-item <?= $page_actuelle == 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="index.php?action=catalogue&page=<?= $page_actuelle - 1 ?><?= $category_id ? '&category=' . $category_id : '' ?>"
                                <?= $page_actuelle == 1 ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                <i class="fas fa-chevron-left me-2"></i>Précédent
                            </a>
                        </li>

                        <!-- Pages -->
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?= $i == $page_actuelle ? 'active' : '' ?>">
                                <a class="page-link" href="index.php?action=catalogue&page=<?= $i ?><?= $category_id ? '&category=' . $category_id : '' ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endfor; ?>

                        <!-- Bouton Suivant -->
                        <li class="page-item <?= $page_actuelle == $total_pages ? 'disabled' : '' ?>">
                            <a class="page-link" href="index.php?action=catalogue&page=<?= $page_actuelle + 1 ?><?= $category_id ? '&category=' . $category_id : '' ?>"
                                <?= $page_actuelle == $total_pages ? 'tabindex="-1" aria-disabled="true"' : '' ?>>
                                Suivant<i class="fas fa-chevron-right ms-2"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>


<?php require_once 'views/footer.php'; ?>