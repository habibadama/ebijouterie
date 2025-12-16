<div class="container-fluid px-4">
    <div class="page-header-section">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="mb-3 mb-md-0">
                <h1 class="h2 fw-bold text-primary mb-2">
                    <i class="fas fa-edit me-2"></i>
                    Modifier le Produit
                </h1>
                <p class="text-muted mb-0">Mettez à jour les informations du produit dans votre catalogue</p>
            </div>
            <a href="index.php?action=admin-products" class="btn btn-outline-secondary btn-action">
                <i class="fas fa-arrow-left me-1"></i>Retour à la liste
            </a>
        </div>
    </div>

    <!-- Messages d'erreur -->
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-notification alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-3 fs-5"></i>
                <div>
                    <h5 class="alert-heading mb-1">Erreur</h5>
                    <?php
                    $messages = [
                        'erreur_modification' => 'Erreur lors de la modification du produit.',
                        'id_manquant' => 'ID du produit manquant.',
                        'upload_error' => 'Erreur lors de l\'upload de l\'image.'
                    ];
                    echo $messages[$_GET['error']] ?? 'Une erreur est survenue!';
                    ?>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card product-edit-card">
        <div class="card-header product-edit-card-header">
            <h3 class="h5 mb-0">
                <i class="fas fa-pencil-alt me-2"></i>
                Édition du produit
            </h3>
        </div>
        <div class="card-body p-4">
            <form method="POST" action="index.php?action=admin-update-product" enctype="multipart/form-data" id="productEditForm">
                <!-- CHAMP CACHÉ OBLIGATOIRE -->
                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                <input type="hidden" name="current_image" value="<?= htmlspecialchars($product['image'] ?? '') ?>">

                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-section-card">
                            <h4 class="form-section-title">
                                <i class="fas fa-info-circle"></i>
                                Informations générales
                            </h4>

                            <div class="mb-4">
                                <label for="name" class="form-label required-field">Nom du produit</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="<?= htmlspecialchars($product['name'] ?? '') ?>" required
                                    placeholder="Entrez le nom du produit">
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="4"
                                    placeholder="Décrivez le produit..."><?= htmlspecialchars($product['description'] ?? '') ?></textarea>
                                <div class="form-hint">Cette description sera visible par les clients.</div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="price" class="form-label required-field">Prix (€)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">€</span>
                                            <input type="number" class="form-control" id="price" name="price"
                                                step="0.01" min="0" value="<?= $product['price'] ?? 0 ?>" required
                                                placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="stock" class="form-label required-field">Stock</label>
                                        <input type="number" class="form-control" id="stock" name="stock"
                                            min="0" value="<?= $product['stock'] ?? 0 ?>" required
                                            placeholder="Quantité en stock">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="category_id" class="form-label required-field">Catégorie</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Sélectionnez une catégorie</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>"
                                            <?= ($category['id'] == ($product['category_id'] ?? '')) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="form-section-card">
                            <h4 class="form-section-title">
                                <i class="fas fa-image"></i>
                                Image du produit
                            </h4>

                            <!-- Zone de téléchargement -->
                            <div class="file-drop-zone mb-4" id="fileDropZone">
                                <div class="file-upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <h5 class="mb-2">Glissez-déposez votre image</h5>
                                <p class="text-muted mb-3">ou cliquez pour parcourir</p>
                                <input type="file" class="d-none" id="image_upload" name="image_upload"
                                    accept="image/jpeg, image/png, image/jpg, image/gif, image/webp">
                                <button type="button" class="btn btn-primary-action btn-action" onclick="document.getElementById('image_upload').click()">
                                    <i class="fas fa-folder-open me-1"></i>Choisir un fichier
                                </button>
                                <div class="form-hint mt-3">
                                    Formats: JPG, PNG, GIF, WebP - Taille max: 2MB
                                </div>
                            </div>

                            <!-- Aperçu de l'image actuelle -->
                            <div class="mb-4">
                                <label class="form-label">Image actuelle</label>
                                <div class="image-preview-wrapper">
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?= htmlspecialchars($product['image']) ?>"
                                            alt="Image actuelle" class="product-image-preview mb-3"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                        <div class="mt-2">
                                            <small class="text-muted">Image actuelle</small>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-muted py-4">
                                            <i class="fas fa-image fa-3x mb-3"></i>
                                            <p class="mb-0">Aucune image définie</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Aperçu de la nouvelle image -->
                            <div id="newImagePreviewContainer" class="mb-4" style="display: none;">
                                <label class="form-label">Nouvelle image (aperçu)</label>
                                <div class="image-preview-wrapper">
                                    <!-- Rempli par JavaScript -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions-section">
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-end">
                        <a href="index.php?action=admin-products" class="btn btn-outline-secondary btn-action">
                            <i class="fas fa-times me-1"></i>Annuler
                        </a>
                        <button type="submit" class="btn btn-primary-action btn-action" id="submitButton">
                            <i class="fas fa-save me-1"></i>Mettre à jour le produit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

</script>