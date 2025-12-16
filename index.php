<?php
// =============================================================================
// POINT D'ENTRÉE DU SITE - ROUTEUR
// =============================================================================

// Définit le fuseau horaire pour tout le site
date_default_timezone_set('Europe/Paris');

// 1. Charge tous les paramètres du site
require_once 'config.php';

// 2. Regarde quelle page l'utilisateur veut voir
// Par défaut, c'est la page d'accueil
$action = $_GET['action'] ?? 'home';

// 3. Dirige vers la bonne page selon l'action
try {
    switch ($action) {
        // === PAGES VISIBLES PAR TOUS ===
        case 'catalogue':  // Liste des produits avec pagination
            $controller = new ProductController();
            $controller->catalogue();
            break;

        case 'search':    // Recherche de produits
            $controller = new ProductController();
            $controller->search();
            break;

        case 'home':      // Page d'accueil
            $controller = new HomeController();
            $controller->index();
            break;

        case 'product':   // Détail d'un produit
            $controller = new ProductController();
            $controller->detail();
            break;

        // === PANIER ET ACHATS ===
        case 'cart':           // Voir le panier
            $controller = new CartController();
            $controller->show();
            break;

        case 'add-to-cart':    // Ajouter au panier
            $controller = new CartController();
            $controller->add();
            break;

        case 'remove-from-cart': // Retirer du panier
            $controller = new CartController();
            $controller->remove();
            break;

        case 'checkout':       // Valider la commande
            $controller = new CartController();
            $controller->checkout();
            break;

        case 'confirmation':   // Page après commande
            $controller = new CartController();
            $controller->confirmation();
            break;

        // === COMPTE CLIENT ===
        case 'my-orders':      // Historique des commandes
            $controller = new UserController();
            $controller->myOrders();
            break;

        case 'cancel-order':   // Annuler une commande
            $controller = new UserController();
            $controller->cancelOrder();
            break;

        case 'register':       // Créer un compte
            $controller = new UserController();
            $controller->register();
            break;

        case 'login':          // Se connecter
            $controller = new UserController();
            $controller->login();
            break;

        case 'logout':         // Se déconnecter
            $controller = new UserController();
            $controller->logout();
            break;

        case 'profile':        // Modifier son profil
            $controller = new UserController();
            $controller->profile();
            break;

        // === ADMINISTRATION ===
        case 'admin':          // Tableau de bord admin
        case 'admin-dashboard':
            $controller = new AdminController();
            $controller->dashboard();
            break;

        // GESTION DES PRODUITS (admin)
        case 'admin-products':      // Liste des produits
            $controller = new AdminController();
            $controller->products();
            break;

        case 'admin-add-product':   // Formulaire d'ajout
            $controller = new AdminController();
            $controller->addProduct();
            break;

        case 'admin-store-product': // Sauvegarde nouveau produit
            $controller = new AdminController();
            $controller->storeProduct();
            break;

        case 'admin-edit-product':  // Formulaire modification
            $controller = new AdminController();
            $controller->editProduct();
            break;

        case 'admin-update-product': // Sauvegarde modification
            $controller = new AdminController();
            $controller->updateProduct();
            break;

        case 'admin-archive-product': // Désactiver un produit
            $controller = new AdminController();
            $controller->archiveProduct();
            break;

        case 'admin-restore-product': // Réactiver un produit
            $controller = new AdminController();
            $controller->restoreProduct();
            break;

        // GESTION DES COMMANDES (admin)
        case 'admin-orders':        // Liste des commandes
            $controller = new AdminController();
            $controller->orders();
            break;

        case 'admin-order-detail':  // Détail d'une commande
            $controller = new AdminController();
            $controller->orderDetail();
            break;

        case 'admin-edit-order':    // Modifier statut commande
            $controller = new AdminController();
            $controller->editOrder();
            break;

        // GESTION DES CLIENTS (admin)
        case 'admin-users':         // Liste des clients
            $controller = new AdminController();
            $controller->users();
            break;

        // === PAGE 404 - PAGE NON TROUVÉE ===
        default:
            http_response_code(404);
            require_once 'views/header.php';
            echo '<div style="text-align: center; padding: 4rem;">
                    <h1>Page non trouvée</h1>
                    <p>La page que vous recherchez n\'existe pas.</p>
                    <a href="index.php?action=home" style="color: #D4AF37;">Retour à l\'accueil</a>
                  </div>';
            require_once 'views/footer.php';
            break;
    }
} catch (Exception $e) {
    // SI QUELQUE CHOSE CASSÉ, ON AFFICHE UN MESSAGE GENTIL
    error_log('Erreur: ' . $e->getMessage());
    http_response_code(500);
    require_once 'views/header.php';
    echo '<div style="text-align: center; padding: 4rem;">
            <h1>Erreur technique</h1>
            <p>Une erreur est survenue. Veuillez réessayer.</p>
            <a href="index.php?action=home" style="color: #D4AF37;">Retour à l\'accueil</a>
          </div>';
    require_once 'views/footer.php';
}
