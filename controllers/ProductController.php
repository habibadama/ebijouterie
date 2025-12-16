<?php

/**
 * Contrôleur pour la gestion des produits
 * Gère l'affichage du catalogue, la recherche et les détails produits
 */
class ProductController
{
    // =====================
    // CATALOGUE AVEC PAGINATION
    // =====================

    /**
     * Affiche le catalogue des produits avec pagination
     * Gère l'affichage par catégorie ou tous les produits
     */
    public function catalogue()
    {
        $productModel = new Product();
        $categoryModel = new Category();

        // Configuration de la pagination - 15 produits par page
        $produits_par_page = 15;
        $page_actuelle = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page_actuelle - 1) * $produits_par_page;

        // Vérifie si on filtre par catégorie
        $category_id = $_GET['category'] ?? null;
        $currentCategory = null;

        if ($category_id) {
            // PAGINATION pour une catégorie spécifique
            $allProducts = $productModel->getByCategory($category_id)->fetchAll();
            $total_produits = count($allProducts);
            $total_pages = ceil($total_produits / $produits_par_page);

            // Validation : empêcher d'aller sur une page qui n'existe pas
            if ($total_pages > 0 && $page_actuelle > $total_pages) {
                $page_actuelle = $total_pages;
                $offset = ($page_actuelle - 1) * $produits_par_page;
            }

            // Récupère seulement les produits de la page courante
            $products = array_slice($allProducts, $offset, $produits_par_page);
            $currentCategory = $categoryModel->getById($category_id);
        } else {
            // PAGINATION pour toutes les catégories
            $total_produits = $productModel->getTotalCount();
            $total_pages = ceil($total_produits / $produits_par_page);

            // Validation de la page
            if ($total_pages > 0 && $page_actuelle > $total_pages) {
                $page_actuelle = $total_pages;
                $offset = ($page_actuelle - 1) * $produits_par_page;
            }

            $products = $productModel->getPaginated($offset, $produits_par_page)->fetchAll();
            $currentCategory = null;
        }

        // Récupère toutes les catégories pour le menu de navigation
        $categories = $categoryModel->getAll()->fetchAll();
        $categoryCounts = $productModel->getCountByCategories();

        // Affiche la page du catalogue
        require_once 'views/header.php';
        require_once 'views/catalogue.php';
        require_once 'views/footer.php';
    }

    // =====================
    // RECHERCHE DE PRODUITS
    // =====================

    /**
     * Gère la recherche de produits avec pagination
     * Permet de chercher par mots-clés et/ou par catégorie
     */
    public function search()
    {
        $productModel = new Product();
        $categoryModel = new Category();

        // Récupère les critères de recherche
        $keywords = $_GET['q'] ?? '';
        $category_id = $_GET['category'] ?? null;

        // Si recherche vide, redirige vers le catalogue normal
        if (empty($keywords)) {
            redirect('index.php?action=catalogue' . ($category_id ? '&category=' . $category_id : ''));
            return;
        }

        // Effectue la recherche dans la base de données
        $stmt = $productModel->search($keywords, $category_id);
        $allProducts = $stmt->fetchAll();

        // Configuration de la pagination pour les résultats
        $produits_par_page = 15;
        $page_actuelle = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $offset = ($page_actuelle - 1) * $produits_par_page;

        $total_produits = count($allProducts);
        $total_pages = ceil($total_produits / $produits_par_page);

        // Validation de la page
        if ($total_pages > 0 && $page_actuelle > $total_pages) {
            $page_actuelle = $total_pages;
            $offset = ($page_actuelle - 1) * $produits_par_page;
        }

        // Prend seulement les produits de la page courante
        $products = array_slice($allProducts, $offset, $produits_par_page);

        // Préparation des données pour l'affichage
        $currentCategory = null;
        if ($category_id) {
            $currentCategory = $categoryModel->getById($category_id);
        }

        $categories = $categoryModel->getAll()->fetchAll();
        $categoryCounts = $productModel->getCountByCategories();

        // Affiche les résultats de recherche
        require_once 'views/header.php';
        require_once 'views/catalogue.php'; // Réutilise la vue catalogue
        require_once 'views/footer.php';
    }

    // =====================
    // VUE DÉTAIL DU PRODUIT
    // =====================

    /**
     * Affiche la page détaillée d'un produit
     * Montre le produit + produits similaires + options d'achat
     */
    public function detail()
    {
        // Vérifie que l'ID produit est bien fourni
        if (!isset($_GET['id'])) {
            redirect('index.php?action=catalogue');
            exit;
        }

        $productModel = new Product();
        $product = $productModel->getById($_GET['id']);

        // Vérifie que le produit existe
        if (!$product) {
            $_SESSION['error'] = "Produit non trouvé";
            redirect('index.php?action=catalogue');
            exit;
        }

        // Récupère les produits similaires (même catégorie)
        $relatedProducts = $productModel->getByCategory($product['category_id'])->fetchAll();
        // Exclut le produit actuel de la liste
        $relatedProducts = array_filter($relatedProducts, function ($p) use ($product) {
            return $p['id'] != $product['id'];
        });
        // Limite à 4 produits maximum
        $relatedProducts = array_slice($relatedProducts, 0, 4);

        // Calcule les options de quantité disponibles
        // Ne propose pas plus de 5 ou que le stock disponible
        $maxQuantity = min(5, $product['stock']);
        $quantityOptions = range(1, $maxQuantity);

        // Affiche la page détaillée du produit
        require_once 'views/header.php';
        require_once 'views/product-detail.php';
        require_once 'views/footer.php';
    }
}
