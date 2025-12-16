<div class="container-fluid px-0">
    <!-- Header avec navigation -->
    <div class="product-form-header bg-gradient-primary text-white py-4 mb-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="header-icon-container me-3">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <div>
                            <h1 class="h3 mb-1 fw-bold">Ajouter un Produit</h1>
                            <p class="mb-0 opacity-75">Remplissez les informations du nouveau produit</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="index.php?action=admin-products" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-arrow-left me-2"></i>Retour aux produits
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card product-form-card shadow-lg border-0">
                    <div class="card-header product-form-card-header bg-white py-4">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="fas fa-cube me-2 text-primary"></i>
                            Informations du produit
                        </h5>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form method="POST" action="index.php?action=admin-store-product" enctype="multipart/form-data" id="productForm">
                            <div class="row g-4">
                                <!-- Colonne gauche - Informations principales -->
                                <div class="col-lg-8">
                                    <!-- Nom du produit -->
                                    <div class="form-field-group">
                                        <label for="name" class="form-label fw-semibold text-dark">
                                            <i class="fas fa-tag me-2 text-primary"></i>
                                            Nom du produit *
                                        </label>
                                        <div class="input-with-icon-container">
                                            <span class="input-icon">
                                                <i class="fas fa-heading"></i>
                                            </span>
                                            <input type="text" class="form-input-styled" id="name" name="name" required
                                                placeholder="Ex: Bague en or 18 carats avec diamants">
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="form-field-group">
                                        <label for="description" class="form-label fw-semibold text-dark">
                                            <i class="fas fa-align-left me-2 text-primary"></i>
                                            Description
                                        </label>
                                        <div class="input-with-icon-container">
                                            <span class="input-icon align-items-start pt-3">
                                                <i class="fas fa-file-alt"></i>
                                            </span>
                                            <textarea class="form-input-styled" id="description" name="description" rows="5"
                                                placeholder="Décrivez en détail les caractéristiques, matériaux et particularités du produit..."></textarea>
                                        </div>
                                        <div class="form-hint">
                                            <i class="fas fa-lightbulb me-1"></i>
                                            Une bonne description améliore les ventes
                                        </div>
                                    </div>

                                    <!-- Prix et Stock -->
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-field-group">
                                                <label for="price" class="form-label fw-semibold text-dark">
                                                    <i class="fas fa-euro-sign me-2 text-success"></i>
                                                    Prix (€) *
                                                </label>
                                                <div class="input-with-icon-container">
                                                    <span class="input-icon">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    </span>
                                                    <input type="number" class="form-input-styled" id="price" name="price"
                                                        step="0.01" min="0" required placeholder="0.00">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-field-group">
                                                <label for="stock" class="form-label fw-semibold text-dark">
                                                    <i class="fas fa-boxes me-2 text-warning"></i>
                                                    Stock *
                                                </label>
                                                <div class="input-with-icon-container">
                                                    <span class="input-icon">
                                                        <i class="fas fa-layer-group"></i>
                                                    </span>
                                                    <input type="number" class="form-input-styled" id="stock" name="stock"
                                                        min="0" value="0" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Catégorie -->
                                    <div class="form-field-group">
                                        <label for="category_id" class="form-label fw-semibold text-dark">
                                            <i class="fas fa-folder me-2 text-info"></i>
                                            Catégorie *
                                        </label>
                                        <div class="input-with-icon-container">
                                            <span class="input-icon">
                                                <i class="fas fa-tags"></i>
                                            </span>
                                            <select class="form-input-styled" id="category_id" name="category_id" required>
                                                <option value="">Sélectionnez une catégorie</option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?= $category['id'] ?>">
                                                        <?= htmlspecialchars($category['name']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Colonne droite - Upload image -->
                                <div class="col-lg-4">
                                    <div class="image-upload-section">
                                        <!-- Zone de téléchargement -->
                                        <div class="image-upload-card text-center p-4">
                                            <div class="upload-icon-container mb-3">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                            </div>
                                            <h6 class="fw-semibold text-dark mb-2">Image du produit</h6>
                                            <p class="text-muted small mb-3">
                                                Glissez-déposez ou cliquez pour uploader
                                            </p>

                                            <div class="file-drop-zone" id="fileUploadArea">
                                                <input type="file" class="file-input-hidden" id="image_upload" name="image_upload"
                                                    accept="image/jpeg, image/png, image/jpg, image/gif, image/webp" required>
                                                <div class="upload-instructions">
                                                    <i class="fas fa-image fa-2x mb-2 text-muted"></i>
                                                    <p class="small mb-2">Formats: JPG, PNG, GIF, WebP</p>
                                                    <p class="small text-muted">Taille max: 2MB</p>
                                                </div>
                                            </div>

                                            <!-- Aperçu de l'image -->
                                            <div id="imagePreview" class="mt-4" style="display: none;">
                                                <div class="image-preview-container position-relative">
                                                    <img src="" alt="Aperçu" class="preview-image rounded shadow">
                                                    <button type="button" class="btn-remove-image-preview" id="removePreview">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="mt-2">
                                                    <small class="text-success">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Image sélectionnée
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Informations upload -->
                                        <div class="upload-guidelines mt-3 p-3 rounded">
                                            <h6 class="fw-semibold text-dark mb-2">
                                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                                Recommandations
                                            </h6>
                                            <ul class="small text-muted mb-0">
                                                <li>Image carrée recommandée (1:1)</li>
                                                <li>Résolution minimale: 500x500px</li>
                                                <li>Fond clair pour meilleur rendu</li>
                                                <li>Produit bien centré et visible</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="row mt-5 pt-4 border-top">
                                <div class="col-12">
                                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-end">
                                        <button type="submit" class="btn btn-success btn-action-primary px-4 py-3 flex-fill flex-md-grow-0">
                                            <i class="fas fa-save me-2"></i>
                                            <span class="fw-semibold">Enregistrer le produit</span>
                                        </button>
                                        <a href="index.php?action=admin-products" class="btn btn-outline-secondary btn-action-secondary px-4 py-3 flex-fill flex-md-grow-0">
                                            <i class="fas fa-times me-2"></i>
                                            Annuler
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>