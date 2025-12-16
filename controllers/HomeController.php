<?php

/**
 * Contrôleur pour la page d'accueil du site
 * Affiche les produits et catégories principales
 */
class HomeController
{
    /**
     * Affiche la page d'accueil avec les produits et catégories
     */
    public function index()
    {
        // Initialise les modèles pour accéder aux données
        $productModel = new Product();
        $categoryModel = new Category();

        // Récupère tous les produits actifs
        $products = $productModel->getAll()->fetchAll();

        // Récupère toutes les catégories
        $categories = $categoryModel->getAll()->fetchAll();

        // Compte le nombre de produits par catégorie (pour les statistiques)
        $categoryCounts = $productModel->getCountByCategories();

        // Charge les vues pour afficher la page
        require_once 'views/header.php';
        require_once 'views/home.php';
        require_once 'views/footer.php';
    }
}
