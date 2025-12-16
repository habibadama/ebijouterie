<!-- views/admin/dashboard.php -->

<!-- En-tête Dashboard -->
<div class="admin-dashboard-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <div class="dashboard-title-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div>
                        <h1 class="h2 mb-1">Tableau de Bord</h1>
                        <p class="mb-0 text-light opacity-75">Vue d'ensemble de votre boutique eBijouterie</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-4">
    <!-- Cartes de Statistiques -->
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="statistics-card statistics-card-products">
                <div class="statistics-icon">
                    <i class="fas fa-gem"></i>
                </div>
                <div class="statistics-content">
                    <h2 class="statistics-value"><?= $totalProducts ?></h2>
                    <p class="statistics-label">Produits</p>
                    <small class="statistics-description">en catalogue</small>
                </div>
                <div class="statistics-footer">
                    <a href="index.php?action=admin-products" class="statistics-link">
                        Voir tous <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="statistics-card statistics-card-orders">
                <div class="statistics-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="statistics-content">
                    <h2 class="statistics-value"><?= $totalOrders ?></h2>
                    <p class="statistics-label">Commandes</p>
                    <small class="statistics-description">au total</small>
                </div>
                <div class="statistics-footer">
                    <a href="index.php?action=admin-orders" class="statistics-link">
                        Voir toutes <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="statistics-card statistics-card-users">
                <div class="statistics-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="statistics-content">
                    <h2 class="statistics-value"><?= $totalUsers ?></h2>
                    <p class="statistics-label">Clients</p>
                    <small class="statistics-description">inscrits</small>
                </div>
                <div class="statistics-footer">
                    <a href="index.php?action=admin-users" class="statistics-link">
                        Voir tous <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="statistics-card statistics-card-revenue">
                <div class="statistics-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="statistics-content">
                    <h2 class="statistics-value"><?= formatPrice($totalRevenue) ?></h2>
                    <p class="statistics-label">Chiffre d'affaires</p>
                    <small class="statistics-description">total</small>
                </div>
                <div class="statistics-footer">
                    <a href="index.php?action=admin-orders" class="statistics-link">
                        Détails <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Dernières commandes -->
        <div class="col-lg-8 mb-4">
            <div class="dashboard-section-card">
                <div class="dashboard-section-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-clock me-2"></i>
                            Commandes Récentes
                        </h5>
                        <a href="index.php?action=admin-orders" class="btn btn-sm btn-outline-primary">
                            Voir tout <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="dashboard-section-body">
                    <?php if (empty($recentOrders)): ?>
                        <div class="empty-state-section">
                            <i class="fas fa-shopping-cart"></i>
                            <p class="mb-2">Aucune commande récente</p>
                            <a href="index.php?action=admin-products" class="btn btn-primary mt-2">
                                <i class="fas fa-gem me-2"></i>Voir les produits
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Client</th>
                                        <th>Date</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentOrders as $order): ?>
                                        <tr>
                                            <td class="fw-bold text-primary">#<?= $order['id'] ?></td>
                                            <td>
                                                <div>
                                                    <strong><?= $order['full_name'] ?></strong>
                                                    <br>
                                                    <small class="text-muted"><?= $order['safe_email'] ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <small class="text-muted d-block"><?= $order['formatted_date'] ?></small>
                                                <small class="text-muted"><?= $order['formatted_time'] ?></small>
                                            </td>
                                            <td class="fw-bold text-success"><?= $order['formatted_total'] ?></td>
                                            <td>
                                                <span class="order-status-badge order-status-<?= $order['status'] ?>">
                                                    <?= ucfirst($order['status']) ?>
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="index.php?action=admin-order-detail&id=<?= $order['id'] ?>"
                                                        class="btn btn-outline-primary" title="Voir détails">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="index.php?action=admin-edit-order&id=<?= $order['id'] ?>"
                                                        class="btn btn-outline-success" title="Modifier statut">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- ✅ CORRIGÉ : Produits récents -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-section-card">
                <div class="dashboard-section-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-clock me-2"></i>
                            Produits Récents
                        </h5>
                        <a href="index.php?action=admin-products" class="btn btn-sm btn-outline-primary">
                            Voir tout <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="dashboard-section-body">
                    <?php if (empty($recentProducts)): ?>
                        <div class="empty-state-section">
                            <i class="fas fa-gem"></i>
                            <p class="mb-2">Aucun produit récent</p>
                            <a href="index.php?action=admin-add-product" class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-plus me-2"></i>Ajouter un produit
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="products-list-container">
                            <?php foreach ($recentProducts as $product): ?>
                                <div class="product-list-item">
                                    <div class="product-thumbnail">
                                        <?php if (!empty($product['image'])): ?>
                                            <img src="<?= htmlspecialchars($product['image']) ?>"
                                                alt="<?= $product['safe_name'] ?>"
                                                class="img-fluid">
                                        <?php else: ?>
                                            <div class="product-image-placeholder">
                                                <i class="fas fa-gem"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-details">
                                        <h6 class="product-title"><?= $product['safe_name'] ?></h6>
                                        <p class="product-price"><?= $product['formatted_price'] ?></p>
                                    </div>
                                    <div class="product-stock-info">
                                        <span class="stock-indicator stock-level-<?= $product['stock_level'] ?>">
                                            <?= $product['stock'] ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-section-card">
                <div class="dashboard-section-header">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Actions Rapides
                    </h5>
                </div>
                <div class="dashboard-section-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="index.php?action=admin-add-product" class="quick-action-item quick-action-add-product">
                                <div class="quick-action-icon">
                                    <i class="fas fa-plus-circle"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6 class="quick-action-title">Ajouter un Produit</h6>
                                    <p class="quick-action-description">Nouvel article</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="index.php?action=admin-orders" class="quick-action-item quick-action-manage-orders">
                                <div class="quick-action-icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6 class="quick-action-title">Gérer les Commandes</h6>
                                    <p class="quick-action-description">Suivi & statut</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="index.php?action=admin-users" class="quick-action-item quick-action-manage-users">
                                <div class="quick-action-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6 class="quick-action-title">Gérer les Clients</h6>
                                    <p class="quick-action-description">Utilisateurs</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="index.php?action=products" class="quick-action-item quick-action-view-store">
                                <div class="quick-action-icon">
                                    <i class="fas fa-store"></i>
                                </div>
                                <div class="quick-action-content">
                                    <h6 class="quick-action-title">Voir la Boutique</h6>
                                    <p class="quick-action-description">Site public</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>