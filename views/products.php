<div class="admin-dashboard-container">
    <!-- Header avec Glassmorphism -->
    <div class="dashboard-hero-section">
        <div class="hero-background-decoration">
            <div class="floating-shapes-container">
                <div class="floating-shape shape-diamond"></div>
                <div class="floating-shape shape-circle"></div>
                <div class="floating-shape shape-triangle"></div>
            </div>
        </div>
        <div class="hero-content-wrapper">
            <div class="hero-title-section">
                <div class="admin-badge-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <div>
                    <h1>Gestion des Bijoux</h1>
                    <p class="hero-subtitle"><?= count($products) ?> création(s) dans votre collection exclusive</p>
                </div>
            </div>
            <a href="index.php?action=admin-add-product" class="btn-create-product">
                <div class="btn-sparkle-effect"></div>
                <i class="fas fa-plus"></i>
                <span>Nouvelle Création</span>
            </a>
        </div>
    </div>

    <!-- Dashboard Cards -->
    <div class="metrics-grid-layout">
        <div class="metric-card-primary">
            <div class="metric-card-glow"></div>
            <div class="metric-card-content">
                <div class="metric-icon-wrapper">
                    <i class="fas fa-gem"></i>
                </div>
                <div class="metric-data-display">
                    <h3><?= count($products) ?></h3>
                    <span>Collection</span>
                </div>
                <div class="metric-trend-indicator">
                    <i class="fas fa-sparkle"></i>
                </div>
            </div>
        </div>

        <div class="metric-card-warning">
            <div class="metric-card-glow"></div>
            <div class="metric-card-content">
                <div class="metric-icon-wrapper">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="metric-data-display">
                    <h3><?= $low_stock_count ?></h3>
                    <span>Stock Faible</span>
                </div>
                <div class="metric-trend-indicator">
                    <i class="fas fa-sparkle"></i>
                </div>
            </div>
        </div>

        <div class="metric-card-danger">
            <div class="metric-card-glow"></div>
            <div class="metric-card-content">
                <div class="metric-icon-wrapper">
                    <i class="fas fa-battery-empty"></i>
                </div>
                <div class="metric-data-display">
                    <h3><?= $out_of_stock_count ?></h3>
                    <span>Épuisé</span>
                </div>
                <div class="metric-trend-indicator">
                    <i class="fas fa-sparkle"></i>
                </div>
            </div>
        </div>

        <div class="metric-card-success">
            <div class="metric-card-glow"></div>
            <div class="metric-card-content">
                <div class="metric-icon-wrapper">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="metric-data-display">
                    <h3><?= $archived_count ?></h3>
                    <span>Archivés</span>
                </div>
                <div class="metric-trend-indicator">
                    <i class="fas fa-sparkle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages de statut -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert-message-success">
            <div class="alert-glow-effect"></div>
            <div class="alert-content-wrapper">
                <div class="alert-icon-container">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-text-content">
                    <h4>Succès !</h4>
                    <p>
                        <?php
                        $messages = [
                            'produit_ajoute' => 'Votre création a été ajoutée avec élégance',
                            'produit_modifie' => 'Les modifications ont été sauvegardées',
                            'produit_supprime' => 'L\'élément a été retiré avec soin'
                        ];
                        echo $messages[$_GET['success']] ?? 'Opération réalisée avec succès';
                        ?>
                    </p>
                </div>
            </div>
            <button class="alert-close-button">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert-message-error">
            <div class="alert-glow-effect"></div>
            <div class="alert-content-wrapper">
                <div class="alert-icon-container">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="alert-text-content">
                    <h4>Attention</h4>
                    <p>
                        <?php
                        $messages = [
                            'erreur_ajout' => 'Impossible d\'ajouter cette création',
                            'erreur_modification' => 'Les modifications n\'ont pas pu être appliquées',
                            'erreur_suppression' => 'Cette pièce ne peut être retirée',
                            'id_manquant' => 'Identifiant de la pièce manquant',
                            'produit_avec_commandes' => 'Cette pièce a été commandée et doit rester dans l\'historique'
                        ];
                        echo $messages[$_GET['error']] ?? 'Une erreur est survenue';
                        ?>
                    </p>
                </div>
            </div>
            <button class="alert-close-button">
                <i class="fas fa-times"></i>
            </button>
        </div>
    <?php endif; ?>

    <!-- Tableau principal -->
    <div class="products-table-container">
        <div class="table-header-section">
            <div class="table-title-section">
                <div class="table-title-icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div>
                    <h2>Collection de Bijoux</h2>
                    <p>Gérez votre inventaire précieux</p>
                </div>
            </div>
            <div class="table-actions-section">
                <div class="search-input-container">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Rechercher une création...">
                    <div class="search-focus-overlay"></div>
                </div>
                <div class="table-action-buttons">
                    <button class="table-action-btn filter-btn" title="Filtrer">
                        <i class="fas fa-sliders-h"></i>
                    </button>
                    <button class="table-action-btn export-btn" title="Exporter">
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="table-content-wrapper">
            <table class="products-data-table">
                <thead>
                    <tr>
                        <th class="column-checkbox">
                            <div class="custom-checkbox">
                                <input type="checkbox" id="select-all-checkbox">
                                <label for="select-all-checkbox"></label>
                            </div>
                        </th>
                        <th class="column-product">Création</th>
                        <th class="column-price">Valeur</th>
                        <th class="column-category">Collection</th>
                        <th class="column-stock">Stock</th>
                        <th class="column-status">Statut</th>
                        <th class="column-actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state-container">
                                    <div class="empty-state-illustration">
                                        <i class="fas fa-gem"></i>
                                    </div>
                                    <h3>Votre écrin est vide</h3>
                                    <p>Créez votre première pièce exclusive</p>
                                    <a href="index.php?action=admin-add-product" class="btn-primary-action">
                                        <i class="fas fa-plus"></i>
                                        Commencer la création
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr class="product-table-row <?= $product['status'] === 'archived' ? 'row-archived' : '' ?>">
                                <td class="column-checkbox">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="product-<?= $product['id'] ?>">
                                        <label for="product-<?= $product['id'] ?>"></label>
                                    </div>
                                </td>
                                <td class="column-product">
                                    <div class="product-card-preview">
                                        <div class="product-image-container">
                                            <?php if (!empty($product['image'])): ?>
                                                <img src="<?= htmlspecialchars($product['image']) ?>"
                                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                                    loading="lazy">
                                                <div class="image-hover-overlay"></div>
                                            <?php else: ?>
                                                <div class="product-image-placeholder">
                                                    <i class="fas fa-gem"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="product-info-container">
                                            <h4 class="product-name-title"><?= htmlspecialchars($product['name']) ?></h4>
                                            <?php if (!empty($product['description'])): ?>
                                                <p class="product-description-text">
                                                    <?= substr(htmlspecialchars($product['description']), 0, 70) ?>...
                                                </p>
                                            <?php endif; ?>
                                            <span class="product-reference-code">REF: #<?= $product['id'] ?></span>
                                        </div>
                                    </div>
                                </td>
                                <td class="column-price">
                                    <div class="price-display-container">
                                        <span class="price-value-text"><?= formatPrice($product['price']) ?></span>
                                    </div>
                                </td>
                                <td class="column-category">
                                    <span class="category-badge"><?= htmlspecialchars($product['category_name'] ?? 'Exclusif') ?></span>
                                </td>
                                <td class="column-stock">
                                    <div class="stock-indicator-widget">
                                        <div class="stock-level-bar">
                                            <div class="stock-bar-fill <?=
                                                                        $product['stock'] > 20 ? 'stock-high' : ($product['stock'] > 5 ? 'stock-medium' : 'stock-low')
                                                                        ?>" style="width: <?=
                                                                                            $product['stock'] > 20 ? '100' : ($product['stock'] > 5 ? '50' : '20')
                                                                                            ?>%"></div>
                                        </div>
                                        <div class="stock-data-display">
                                            <span class="stock-quantity"><?= $product['stock'] ?></span>
                                            <span class="stock-label-text">en stock</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="column-status">
                                    <?php if ($product['status'] === 'active'): ?>
                                        <div class="status-indicator-badge <?=
                                                                            $product['stock'] > 20 ? 'status-active' : ($product['stock'] > 5 ? 'status-warning' : 'status-danger')
                                                                            ?>">
                                            <div class="status-dot-indicator"></div>
                                            <?=
                                            $product['stock'] > 20 ? 'Disponible' : ($product['stock'] > 5 ? 'Stock limité' : 'Épuisé')
                                            ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="status-indicator-badge status-archived">
                                            <div class="status-dot-indicator"></div>
                                            Archivé
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="column-actions">
                                    <div class="action-buttons-toolbar">
                                        <a href="index.php?action=admin-edit-product&id=<?= $product['id'] ?>"
                                            class="action-button edit-button" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?action=product&id=<?= $product['id'] ?>"
                                            class="action-button view-button" title="Prévisualiser">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <?php if ($product['status'] === 'active'): ?>
                                            <a href="index.php?action=admin-archive-product&id=<?= $product['id'] ?>"
                                                class="action-button archive-button"
                                                title="Archiver"
                                                onclick="return confirm('Archiver \'<?= addslashes($product['name']) ?>\' ?')">
                                                <i class="fas fa-archive"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="index.php?action=admin-restore-product&id=<?= $product['id'] ?>"
                                                class="action-button restore-button"
                                                title="Restaurer"
                                                onclick="return confirm('Restaurer \'<?= addslashes($product['name']) ?>\' ?')">
                                                <i class="fas fa-undo"></i>
                                            </a>
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
</div>

<style>
    /* ===== VARIABLES CSS ===== */
    :root {
        --primary-color: #6366f1;
        --primary-light: #818cf8;
        --primary-dark: #4f46e5;
        --secondary-color: #8b5cf6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --dark-color: #1e293b;
        --light-color: #f8fafc;
        --white-color: #ffffff;
        --gray-color: #64748b;
        --gray-light: #e2e8f0;
        --gray-dark: #475569;

        --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        --gradient-success: linear-gradient(135deg, var(--success-color), #34d399);
        --gradient-warning: linear-gradient(135deg, var(--warning-color), #fbbf24);
        --gradient-danger: linear-gradient(135deg, var(--danger-color), #f87171);

        --shadow-small: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --shadow-medium: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-large: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        --shadow-extra-large: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        --shadow-glow: 0 0 20px rgba(99, 102, 241, 0.3);

        --border-radius-small: 8px;
        --border-radius-medium: 12px;
        --border-radius-large: 16px;
        --border-radius-extra-large: 24px;

        --transition-default: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        --transition-slow: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ===== CONTAINER PRINCIPAL ===== */
    .admin-dashboard-container {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        min-height: 100vh;
        padding: 2rem;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    }

    /* ===== SECTION HERO ===== */
    .dashboard-hero-section {
        position: relative;
        background: var(--white-color);
        border-radius: var(--border-radius-extra-large);
        padding: 3rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-large);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }

    .hero-background-decoration {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: var(--gradient-primary);
        opacity: 0.05;
    }

    .floating-shapes-container {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        pointer-events: none;
    }

    .floating-shape {
        position: absolute;
        border-radius: 50%;
        background: var(--primary-color);
        opacity: 0.1;
        animation: floatAnimation 6s ease-in-out infinite;
    }

    .shape-diamond {
        top: 10%;
        left: 5%;
        width: 100px;
        height: 100px;
        animation-delay: 0s;
    }

    .shape-circle {
        top: 60%;
        right: 10%;
        width: 150px;
        height: 150px;
        animation-delay: 2s;
    }

    .shape-triangle {
        bottom: 20%;
        left: 60%;
        width: 80px;
        height: 80px;
        animation-delay: 4s;
    }

    .hero-content-wrapper {
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .hero-title-section {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .admin-badge-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-primary);
        border-radius: var(--border-radius-large);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white-color);
        font-size: 2rem;
        box-shadow: var(--shadow-glow);
    }

    .hero-title-section h1 {
        font-size: 2.5rem;
        font-weight: 800;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        line-height: 1.2;
    }

    .hero-subtitle {
        color: var(--gray-color);
        font-size: 1.1rem;
        margin: 0.5rem 0 0 0;
        font-weight: 500;
    }

    /* ===== BOUTON CRÉATION ===== */
    .btn-create-product {
        position: relative;
        background: var(--gradient-primary);
        border: none;
        padding: 1rem 2rem;
        border-radius: var(--border-radius-medium);
        color: var(--white-color);
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: var(--transition-default);
        box-shadow: var(--shadow-large);
        overflow: hidden;
    }

    .btn-create-product:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-extra-large);
    }

    .btn-sparkle-effect {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 20px;
        height: 20px;
        background: var(--white-color);
        border-radius: 50%;
        opacity: 0;
        transition: var(--transition-default);
    }

    .btn-create-product:hover .btn-sparkle-effect {
        opacity: 1;
        animation: sparkleAnimation 1s ease-in-out;
    }

    /* ===== GRILLE DE MÉTRIQUES ===== */
    .metrics-grid-layout {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .metric-card-primary,
    .metric-card-warning,
    .metric-card-danger,
    .metric-card-success {
        position: relative;
        background: var(--white-color);
        border-radius: var(--border-radius-large);
        padding: 2rem;
        box-shadow: var(--shadow-medium);
        transition: var(--transition-default);
        overflow: hidden;
        border: 1px solid var(--gray-light);
    }

    .metric-card-primary:hover,
    .metric-card-warning:hover,
    .metric-card-danger:hover,
    .metric-card-success:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-extra-large);
    }

    .metric-card-glow {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        opacity: 0;
        transition: var(--transition-default);
    }

    .metric-card-primary:hover .metric-card-glow {
        opacity: 1;
        background: var(--gradient-primary);
    }

    .metric-card-warning:hover .metric-card-glow {
        opacity: 1;
        background: var(--gradient-warning);
    }

    .metric-card-danger:hover .metric-card-glow {
        opacity: 1;
        background: var(--gradient-danger);
    }

    .metric-card-success:hover .metric-card-glow {
        opacity: 1;
        background: var(--gradient-success);
    }

    .metric-card-content {
        position: relative;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .metric-icon-wrapper {
        width: 70px;
        height: 70px;
        border-radius: var(--border-radius-medium);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: var(--white-color);
    }

    .metric-card-primary .metric-icon-wrapper {
        background: var(--gradient-primary);
    }

    .metric-card-warning .metric-icon-wrapper {
        background: var(--gradient-warning);
    }

    .metric-card-danger .metric-icon-wrapper {
        background: var(--gradient-danger);
    }

    .metric-card-success .metric-icon-wrapper {
        background: var(--gradient-success);
    }

    .metric-data-display h3 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        color: var(--dark-color);
    }

    .metric-data-display span {
        color: var(--gray-color);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .metric-trend-indicator {
        position: absolute;
        top: 1rem;
        right: 1rem;
        color: var(--gray-light);
    }

    /* ===== ALERTES ===== */
    .alert-message-success,
    .alert-message-error {
        position: relative;
        background: var(--white-color);
        border-radius: var(--border-radius-large);
        padding: 1.5rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow-medium);
        display: flex;
        align-items: center;
        justify-content: space-between;
        overflow: hidden;
        border-left: 4px solid;
        animation: slideInAnimation 0.5s ease-out;
    }

    .alert-message-success {
        border-left-color: var(--success-color);
        background: linear-gradient(135deg, #f0fdf4, var(--white-color));
    }

    .alert-message-error {
        border-left-color: var(--danger-color);
        background: linear-gradient(135deg, #fef2f2, var(--white-color));
    }

    .alert-glow-effect {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 4px;
        background: currentColor;
        opacity: 0.3;
    }

    .alert-content-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
    }

    .alert-icon-container {
        width: 50px;
        height: 50px;
        border-radius: var(--border-radius-medium);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: var(--white-color);
    }

    .alert-message-success .alert-icon-container {
        background: var(--success-color);
    }

    .alert-message-error .alert-icon-container {
        background: var(--danger-color);
    }

    .alert-text-content h4 {
        margin: 0 0 0.25rem 0;
        font-weight: 600;
        color: var(--dark-color);
    }

    .alert-text-content p {
        margin: 0;
        color: var(--gray-color);
    }

    .alert-close-button {
        background: none;
        border: none;
        color: var(--gray-color);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: var(--border-radius-small);
        transition: var(--transition-default);
    }

    .alert-close-button:hover {
        background: var(--gray-light);
        color: var(--dark-color);
    }

    /* ===== TABLEAU DES PRODUITS ===== */
    .products-table-container {
        background: var(--white-color);
        border-radius: var(--border-radius-extra-large);
        box-shadow: var(--shadow-large);
        overflow: hidden;
        border: 1px solid var(--gray-light);
    }

    .table-header-section {
        padding: 2rem;
        border-bottom: 1px solid var(--gray-light);
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: var(--white-color);
    }

    .table-title-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .table-title-icon {
        width: 50px;
        height: 50px;
        background: var(--gradient-primary);
        border-radius: var(--border-radius-medium);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white-color);
        font-size: 1.3rem;
    }

    .table-title-section h2 {
        margin: 0;
        font-weight: 700;
        color: var(--dark-color);
        font-size: 1.5rem;
    }

    .table-title-section p {
        margin: 0.25rem 0 0 0;
        color: var(--gray-color);
        font-size: 0.9rem;
    }

    .table-actions-section {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* ===== RECHERCHE ===== */
    .search-input-container {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input-container i {
        position: absolute;
        left: 1rem;
        color: var(--gray-color);
        z-index: 2;
    }

    .search-input-container input {
        background: var(--light-color);
        border: 1px solid var(--gray-light);
        border-radius: var(--border-radius-medium);
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        color: var(--dark-color);
        width: 300px;
        transition: var(--transition-default);
        font-size: 0.9rem;
    }

    .search-input-container input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        background: var(--white-color);
    }

    .search-focus-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: var(--border-radius-medium);
        background: var(--gradient-primary);
        opacity: 0;
        transition: var(--transition-default);
        z-index: -1;
    }

    .search-input-container:focus-within .search-focus-overlay {
        opacity: 0.05;
    }

    /* ===== BOUTONS D'ACTION ===== */
    .table-action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .table-action-btn {
        width: 45px;
        height: 45px;
        background: var(--light-color);
        border: 1px solid var(--gray-light);
        border-radius: var(--border-radius-medium);
        color: var(--gray-color);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition-default);
        cursor: pointer;
        text-decoration: none;
        font-size: 0.9rem;
    }

    .table-action-btn:hover {
        background: var(--primary-color);
        color: var(--white-color);
        border-color: var(--primary-color);
        transform: translateY(-1px);
    }

    /* ===== CONTENU DU TABLEAU ===== */
    .table-content-wrapper {
        overflow-x: auto;
    }

    .products-data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .products-data-table th {
        background: var(--light-color);
        padding: 1.5rem;
        text-align: left;
        font-weight: 600;
        color: var(--gray-color);
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        border-bottom: 1px solid var(--gray-light);
    }

    .products-data-table td {
        padding: 1.5rem;
        border-bottom: 1px solid var(--gray-light);
        vertical-align: middle;
        transition: var(--transition-default);
    }

    .product-table-row:hover {
        background: var(--light-color);
    }

    .row-archived {
        background: rgba(245, 158, 11, 0.05);
    }

    /* ===== CHECKBOX PERSONNALISÉ ===== */
    .custom-checkbox {
        position: relative;
    }

    .custom-checkbox input[type="checkbox"] {
        display: none;
    }

    .custom-checkbox label {
        width: 20px;
        height: 20px;
        border: 2px solid var(--gray-light);
        border-radius: 6px;
        display: block;
        cursor: pointer;
        transition: var(--transition-default);
        position: relative;
    }

    .custom-checkbox input[type="checkbox"]:checked+label {
        background: var(--gradient-primary);
        border-color: var(--primary-color);
    }

    .custom-checkbox input[type="checkbox"]:checked+label::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--white-color);
        font-weight: bold;
        font-size: 12px;
    }

    /* ===== APERÇU PRODUIT ===== */
    .product-card-preview {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .product-image-container {
        width: 80px;
        height: 80px;
        border-radius: var(--border-radius-medium);
        overflow: hidden;
        position: relative;
        background: var(--light-color);
        border: 1px solid var(--gray-light);
        flex-shrink: 0;
    }

    .product-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition-default);
    }

    .product-card-preview:hover .product-image-container img {
        transform: scale(1.1);
    }

    .image-hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), transparent);
        opacity: 0;
        transition: var(--transition-default);
    }

    .product-card-preview:hover .image-hover-overlay {
        opacity: 1;
    }

    .product-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--gradient-primary);
        color: var(--white-color);
        font-size: 1.5rem;
    }

    .product-info-container {
        flex: 1;
    }

    .product-name-title {
        font-weight: 600;
        color: var(--dark-color);
        margin: 0 0 0.5rem 0;
        font-size: 1.1rem;
    }

    .product-description-text {
        color: var(--gray-color);
        font-size: 0.9rem;
        margin: 0 0 0.5rem 0;
        line-height: 1.4;
    }

    .product-reference-code {
        color: var(--primary-color);
        font-size: 0.8rem;
        font-family: monospace;
        font-weight: 600;
    }

    /* ===== PRIX ===== */
    .price-display-container {
        text-align: center;
    }

    .price-value-text {
        font-weight: 700;
        font-size: 1.2rem;
        background: var(--gradient-primary);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* ===== CATÉGORIE ===== */
    .category-badge {
        background: var(--light-color);
        color: var(--dark-color);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        border: 1px solid var(--gray-light);
    }

    /* ===== INDICATEUR DE STOCK ===== */
    .stock-indicator-widget {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stock-level-bar {
        width: 60px;
        height: 8px;
        background: var(--gray-light);
        border-radius: 4px;
        overflow: hidden;
    }

    .stock-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: var(--transition-slow);
    }

    .stock-bar-fill.stock-high {
        background: var(--success-color);
    }

    .stock-bar-fill.stock-medium {
        background: var(--warning-color);
    }

    .stock-bar-fill.stock-low {
        background: var(--danger-color);
    }

    .stock-data-display {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .stock-quantity {
        font-weight: 700;
        color: var(--dark-color);
        font-size: 1.1rem;
    }

    .stock-label-text {
        color: var(--gray-color);
        font-size: 0.7rem;
        text-transform: uppercase;
    }

    /* ===== INDICATEUR DE STATUT ===== */
    .status-indicator-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-dot-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: pulseAnimation 2s infinite;
    }

    .status-indicator-badge.status-active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
    }

    .status-indicator-badge.status-active .status-dot-indicator {
        background: var(--success-color);
    }

    .status-indicator-badge.status-warning {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
    }

    .status-indicator-badge.status-warning .status-dot-indicator {
        background: var(--warning-color);
    }

    .status-indicator-badge.status-danger {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
    }

    .status-indicator-badge.status-danger .status-dot-indicator {
        background: var(--danger-color);
    }

    .status-indicator-badge.status-archived {
        background: rgba(139, 92, 246, 0.1);
        color: var(--secondary-color);
    }

    .status-indicator-badge.status-archived .status-dot-indicator {
        background: var(--secondary-color);
    }

    /* ===== BARRE D'OUTILS D'ACTION ===== */
    .action-buttons-toolbar {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .action-button {
        width: 35px;
        height: 35px;
        background: var(--light-color);
        border: 1px solid var(--gray-light);
        border-radius: var(--border-radius-small);
        color: var(--gray-color);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: var(--transition-default);
        font-size: 0.8rem;
    }

    .action-button.edit-button {
        color: var(--primary-color);
    }

    .action-button.view-button {
        color: var(--success-color);
    }

    .action-button.archive-button {
        color: var(--warning-color);
    }

    .action-button.restore-button {
        color: var(--secondary-color);
    }

    .action-button.edit-button:hover {
        background: var(--primary-color);
        color: var(--white-color);
    }

    .action-button.view-button:hover {
        background: var(--success-color);
        color: var(--white-color);
    }

    .action-button.archive-button:hover {
        background: var(--warning-color);
        color: var(--white-color);
    }

    .action-button.restore-button:hover {
        background: var(--secondary-color);
        color: var(--white-color);
    }

    /* ===== ÉTAT VIDE ===== */
    .empty-state-container {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state-illustration {
        font-size: 4rem;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
        opacity: 0.5;
        animation: floatAnimation 3s ease-in-out infinite;
    }

    .empty-state-container h3 {
        color: var(--dark-color);
        margin-bottom: 1rem;
        font-weight: 700;
    }

    .empty-state-container p {
        color: var(--gray-color);
        margin-bottom: 2rem;
    }

    .btn-primary-action {
        background: var(--gradient-primary);
        border: none;
        padding: 1rem 2rem;
        border-radius: var(--border-radius-medium);
        color: var(--white-color);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: var(--transition-default);
        box-shadow: var(--shadow-large);
    }

    .btn-primary-action:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-extra-large);
        color: var(--white-color);
    }

    /* ===== ANIMATIONS ===== */
    @keyframes floatAnimation {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
        }

        50% {
            transform: translateY(-10px) rotate(5deg);
        }
    }

    @keyframes sparkleAnimation {
        0% {
            transform: scale(0) rotate(0deg);
            opacity: 0;
        }

        50% {
            transform: scale(1) rotate(180deg);
            opacity: 1;
        }

        100% {
            transform: scale(0) rotate(360deg);
            opacity: 0;
        }
    }

    @keyframes pulseAnimation {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0.5;
        }
    }

    @keyframes slideInAnimation {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .admin-dashboard-container {
            padding: 1rem;
        }

        .dashboard-hero-section {
            padding: 2rem;
        }

        .hero-content-wrapper {
            flex-direction: column;
            gap: 2rem;
            text-align: center;
        }

        .hero-title-section {
            flex-direction: column;
            gap: 1rem;
        }

        .metrics-grid-layout {
            grid-template-columns: 1fr;
        }

        .table-header-section {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .table-actions-section {
            justify-content: space-between;
        }

        .search-input-container input {
            width: 200px;
        }

        .product-card-preview {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .stock-indicator-widget {
            flex-direction: column;
            gap: 0.5rem;
        }

        .action-buttons-toolbar {
            flex-direction: column;
        }

        .products-data-table th,
        .products-data-table td {
            padding: 1rem 0.5rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation des cartes de métriques
        const metricCards = document.querySelectorAll('.metric-card-primary, .metric-card-warning, .metric-card-danger, .metric-card-success');
        metricCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'all 0.6s ease';

                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 50);
            }, index * 150);
        });

        // Recherche en temps réel avec debounce
        let searchTimeout;
        const searchInput = document.querySelector('.search-input-container input');

        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('.product-table-row');

                    rows.forEach(row => {
                        const productName = row.querySelector('.product-name-title').textContent.toLowerCase();
                        const productDesc = row.querySelector('.product-description-text')?.textContent.toLowerCase() || '';
                        const productRef = row.querySelector('.product-reference-code').textContent.toLowerCase();

                        if (productName.includes(searchTerm) || productDesc.includes(searchTerm) || productRef.includes(searchTerm)) {
                            row.style.display = '';
                            row.classList.add('fade-in');
                        } else {
                            row.classList.add('fade-out');
                            setTimeout(() => {
                                row.style.display = 'none';
                                row.classList.remove('fade-out');
                            }, 300);
                        }
                    });
                }, 300);
            });
        }

        // Fermeture des alertes
        const closeButtons = document.querySelectorAll('.alert-close-button');
        closeButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const alert = this.closest('.alert-message-success, .alert-message-error');
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    alert.remove();
                }, 300);
            });
        });

        // Animation des lignes au chargement
        const tableRows = document.querySelectorAll('.product-table-row');
        tableRows.forEach((row, index) => {
            setTimeout(() => {
                row.style.opacity = '0';
                row.style.transform = 'translateX(-20px)';
                row.style.transition = 'all 0.4s ease';

                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, 50);
            }, index * 50);
        });

        // Gestion des images de chargement
        const productImages = document.querySelectorAll('.product-image-container img');
        productImages.forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });

            img.addEventListener('error', function() {
                const parent = this.closest('.product-image-container');
                parent.innerHTML = '<div class="product-image-placeholder"><i class="fas fa-gem"></i></div>';
            });
        });
    });
</script>