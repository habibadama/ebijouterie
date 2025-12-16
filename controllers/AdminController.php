<?php

/**
 * Contrôleur pour la gestion de l'administration
 * Gère le dashboard, produits, commandes et utilisateurs
 */
class AdminController
{
    /**
     * Vérifie que l'utilisateur est admin avant chaque action
     */
    public function __construct()
    {
        if (!isAdmin()) {
            redirect('index.php?action=login');
        }
    }

    /**
     * Affiche le tableau de bord admin avec les statistiques
     */
    public function dashboard()
    {
        // Initialisation des modèles pour accéder aux données
        $productModel = new Product();
        $purchaseModel = new Purchase();
        $userModel = new User();

        try {
            // Récupération des données principales
            $allProducts = $productModel->getAll()->fetchAll();
            $allOrders = $purchaseModel->getAll()->fetchAll();
            $allUsers = $userModel->getAllUsers();

            // Calcul des totaux
            $totalProducts = count($allProducts);
            $totalOrders = count($allOrders);
            $totalUsers = count($allUsers);

            // Calcul du revenu total depuis toutes les commandes
            $totalRevenue = 0;
            foreach ($allOrders as $order) {
                $totalRevenue += floatval($order['total_price'] ?? 0);
            }

            // Préparation des 5 commandes les plus récentes pour l'affichage
            $recentOrders = array_slice($allOrders, 0, 5);
            foreach ($recentOrders as &$order) {
                $order['formatted_date'] = date('d/m/Y', strtotime($order['created_at']));
                $order['formatted_time'] = date('H:i', strtotime($order['created_at']));
                $order['formatted_total'] = formatPrice($order['total_price']);
                $order['full_name'] = htmlspecialchars(
                    ($order['firstname'] ?? 'Client') . ' ' . ($order['lastname'] ?? '')
                );
                $order['safe_email'] = htmlspecialchars($order['email'] ?? 'Email non disponible');
            }

            // Préparation des 5 produits les plus récents pour l'affichage
            $recentProducts = array_slice($allProducts, 0, 5);
            foreach ($recentProducts as &$product) {
                $product['formatted_price'] = formatPrice($product['price']);
                // Détermine le niveau de stock (élevé/faible/épuisé)
                $product['stock_level'] = $product['stock'] > 5 ? 'high' : ($product['stock'] > 0 ? 'low' : 'none');
                $product['safe_name'] = htmlspecialchars($product['name']);
            }
        } catch (Exception $e) {
            // En cas d'erreur, initialisation avec des valeurs par défaut
            $totalProducts = 0;
            $totalOrders = 0;
            $totalUsers = 0;
            $totalRevenue = 0;
            $recentOrders = [];
            $recentProducts = [];

            error_log("Erreur dashboard: " . $e->getMessage());
            $_SESSION['error'] = "Erreur lors du chargement du tableau de bord";
        }

        // Affichage de la vue du dashboard
        require_once 'views/header.php';
        require_once 'views/admin/dashboard.php';
        require_once 'views/footer.php';
    }

    /**
     * Gère l'affichage de la liste des produits
     */
    public function products()
    {
        $productModel = new Product();
        $categoryModel = new Category();

        // Récupération de tous les produits et catégories
        $products = $productModel->getAllForAdmin()->fetchAll();
        $categories = $categoryModel->getAll()->fetchAll();

        // Comptage des produits avec stock faible et épuisés
        $low_stock_count = count($productModel->getLowStockProducts(5));
        $out_of_stock_count = count(array_filter($products, function ($p) {
            return $p['stock'] == 0 && $p['status'] === 'active';
        }));

        $archived_count = $productModel->getArchivedCount();

        require_once 'views/header.php';
        require_once 'views/products.php';
        require_once 'views/footer.php';
    }

    /**
     * Affiche la liste de toutes les commandes
     */
    public function orders()
    {
        $purchaseModel = new Purchase();
        $orders = $purchaseModel->getAll()->fetchAll();

        require_once 'views/header.php';
        require_once 'views/orders.php';
        require_once 'views/footer.php';
    }

    /**
     * Affiche la liste de tous les utilisateurs
     */
    public function users()
    {
        $userModel = new User();
        $users = $userModel->getAllUsers();

        require_once 'views/header.php';
        require_once 'views/users.php';
        require_once 'views/footer.php';
    }

    /**
     * Archive un produit (suppression logique)
     */
    public function archiveProduct()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID produit manquant";
            redirect('index.php?action=admin-products');
        }

        $productId = $_GET['id'];
        $productModel = new Product();

        if ($productModel->archive($productId)) {
            $_SESSION['success'] = "Produit archivé avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de l'archivage";
        }

        redirect('index.php?action=admin-products');
    }

    /**
     * Restaure un produit précédemment archivé
     */
    public function restoreProduct()
    {
        if (!isset($_GET['id'])) {
            $_SESSION['error'] = "ID produit manquant";
            redirect('index.php?action=admin-products');
        }

        $productId = $_GET['id'];
        $productModel = new Product();

        if ($productModel->restore($productId)) {
            $_SESSION['success'] = "Produit restauré avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de la restauration";
        }

        redirect('index.php?action=admin-products');
    }

    /**
     * Affiche le formulaire d'ajout de produit
     */
    public function addProduct()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getAll()->fetchAll();

        require_once 'views/header.php';
        require_once 'views/admin/add-product.php';
        require_once 'views/footer.php';
    }

    /**
     * Traite l'ajout d'un nouveau produit
     */
    public function storeProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productModel = new Product();

            // Gestion de l'upload de l'image
            $imageFileName = $this->handleImageUpload();

            // Préparation des données du produit
            $data = [
                'name' => trim($_POST['name']),
                'price' => floatval($_POST['price']),
                'category_id' => intval($_POST['category_id']),
                'description' => trim($_POST['description'] ?? ''),
                'image' => 'assets/images/products/' . $imageFileName,
                'stock' => intval($_POST['stock'] ?? 0)
            ];

            if ($productModel->create($data)) {
                redirect('index.php?action=admin-products&success=produit_ajoute');
            } else {
                // En cas d'erreur, supprime l'image uploadée
                if ($imageFileName && file_exists('assets/images/products/' . $imageFileName)) {
                    unlink('assets/images/products/' . $imageFileName);
                }
                redirect('index.php?action=admin-add-product&error=erreur_ajout');
            }
        } else {
            redirect('index.php?action=admin-products');
        }
    }

    /**
     * Gère l'upload d'une image produit
     * @return string Nom du fichier image
     */
    private function handleImageUpload()
    {
        // Si pas d'upload ou erreur, utilise l'image par défaut
        if (!isset($_FILES['image_upload']) || $_FILES['image_upload']['error'] !== UPLOAD_ERR_OK) {
            return 'default-product.jpg';
        }

        $file = $_FILES['image_upload'];
        $uploadDir = 'assets/images/products/';

        // Crée le dossier s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Génère un nom de fichier unique
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
        $filePath = $uploadDir . $fileName;

        // Vérifie l'extension du fichier
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            return 'default-product.jpg';
        }

        // Vérifie la taille du fichier (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            return 'default-product.jpg';
        }

        // Déplace le fichier uploadé
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            return $fileName;
        }

        return 'default-product.jpg';
    }

    /**
     * Affiche le formulaire d'édition d'un produit
     */
    public function editProduct()
    {
        if (!isset($_GET['id'])) {
            redirect('index.php?action=admin-products');
        }

        $productModel = new Product();
        $categoryModel = new Category();

        $product = $productModel->getById($_GET['id']);
        $categories = $categoryModel->getAll()->fetchAll();

        if (!$product) {
            redirect('index.php?action=admin-products');
        }

        // Préparation du libellé du statut pour l'affichage
        $currentStatusLabel = $this->getStatusLabel($product['status']);

        require_once 'views/header.php';
        require_once 'views/admin/edit-product.php';
        require_once 'views/footer.php';
    }

    /**
     * Traite la mise à jour d'un produit
     */
    public function updateProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $productModel = new Product();

            $currentProduct = $productModel->getById($_POST['id']);
            if (!$currentProduct) {
                $_SESSION['error'] = "Produit non trouvé";
                redirect('index.php?action=admin-products');
                return;
            }

            // Garde l'image actuelle par défaut
            $imagePath = $_POST['current_image'] ?? $currentProduct['image'];

            // Si nouvelle image uploadée, la traite
            if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] === UPLOAD_ERR_OK) {
                $newImageFileName = $this->handleImageUpload();
                if ($newImageFileName !== 'default-product.jpg') {
                    $imagePath = 'assets/images/products/' . $newImageFileName;

                    // Supprime l'ancienne image si ce n'est pas l'image par défaut
                    $oldImage = $_POST['current_image'] ?? $currentProduct['image'];
                    if (
                        $oldImage &&
                        $oldImage !== 'assets/images/products/default-product.jpg' &&
                        file_exists($oldImage)
                    ) {
                        unlink($oldImage);
                    }
                }
            }

            // Préparation des données mises à jour
            $data = [
                'name' => trim($_POST['name']),
                'price' => floatval($_POST['price']),
                'category_id' => intval($_POST['category_id']),
                'description' => trim($_POST['description'] ?? ''),
                'image' => $imagePath,
                'stock' => intval($_POST['stock'] ?? 0)
            ];

            // Validation des données obligatoires
            if (empty($data['name']) || $data['price'] <= 0) {
                $_SESSION['error'] = "Le nom et le prix sont obligatoires";
                redirect('index.php?action=admin-edit-product&id=' . $_POST['id']);
                return;
            }

            if ($productModel->update($_POST['id'], $data)) {
                $_SESSION['success'] = "Produit modifié avec succès";
                redirect('index.php?action=admin-products&success=produit_modifie');
            } else {
                $_SESSION['error'] = "Erreur lors de la modification";
                redirect('index.php?action=admin-edit-product&id=' . $_POST['id'] . '&error=erreur_modification');
            }
        } else {
            redirect('index.php?action=admin-products');
        }
    }

    /**
     * Affiche les détails d'une commande
     */
    public function orderDetail()
    {
        if (!isset($_GET['id'])) {
            redirect('index.php?action=admin-orders');
        }

        $purchaseModel = new Purchase();
        $purchaseItemModel = new PurchaseItem();

        $order = $purchaseModel->getById($_GET['id']);
        $items = $purchaseItemModel->getByPurchaseId($_GET['id']);

        if (!$order) {
            $_SESSION['error'] = "Commande non trouvée";
            redirect('index.php?action=admin-orders');
        }

        // Préparation du libellé du statut pour l'affichage
        $currentStatusLabel = $this->getStatusLabel($order['status']);

        require_once 'views/header.php';
        require_once 'views/admin/order-detail.php';
        require_once 'views/footer.php';
    }

    /**
     * Traite la modification du statut d'une commande
     */
    public function editOrder()
    {
        if (!isset($_GET['id'])) {
            redirect('index.php?action=admin-orders');
        }

        $purchaseModel = new Purchase();
        $order = $purchaseModel->getById($_GET['id']);

        if (!$order) {
            $_SESSION['error'] = "Commande non trouvée";
            redirect('index.php?action=admin-orders');
        }

        // Traitement du formulaire de mise à jour
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newStatus = $_POST['status'];

            if ($purchaseModel->updateStatus($_GET['id'], $newStatus)) {
                $_SESSION['success'] = "Statut de la commande mis à jour";
            } else {
                $_SESSION['error'] = "Erreur lors de la mise à jour";
            }

            redirect('index.php?action=admin-order-detail&id=' . $_GET['id']);
        }

        // Préparation du libellé du statut pour l'affichage
        $currentStatusLabel = $this->getStatusLabel($order['status']);

        require_once 'views/header.php';
        require_once 'views/admin/edit-order.php';
        require_once 'views/footer.php';
    }

    /**
     * Convertit un code statut en libellé lisible
     * @param string $status Code du statut
     * @return string Libellé en français
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'En attente',
            'confirmed' => 'Confirmée',
            'shipped' => 'Expédiée',
            'completed' => 'Livrée',
            'cancelled' => 'Annulée'
        ];
        return $labels[$status] ?? $status;
    }
}
