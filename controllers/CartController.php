<?php

/**
 * Contrôleur pour la gestion du panier et des commandes
 * Gère l'ajout, suppression, validation et confirmation des achats
 */
class CartController
{
    /**
     * Calcule le total du panier
     * @param array $cart Tableau des articles du panier
     * @return float Montant total
     */
    private function calculateCartTotal($cart)
    {
        $total = 0;
        foreach ($cart as $item) {
            // Prix de l'article × quantité
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Affiche le contenu du panier
     */
    public function show()
    {
        // Récupère le panier depuis la session ou un tableau vide
        $cart = $_SESSION['cart'] ?? [];
        // Calcule le total à payer
        $total = $this->calculateCartTotal($cart);

        // Affiche la page du panier
        require_once 'views/header.php';
        require_once 'views/cart.php';
        require_once 'views/footer.php';
    }

    /**
     * Ajoute un produit au panier
     */
    public function add()
    {
        // EMPÊCHER L'ADMIN D'AJOUTER AU PANIER
        if (isAdmin()) {
            $_SESSION['error'] = "Action non autorisée. Les administrateurs ne peuvent pas effectuer d'achats.";
            redirect('index.php?action=catalogue');
            exit;
        }

        // Vérifier que l'utilisateur est connecté (client normal)
        if (!isLoggedIn()) {
            $_SESSION['error'] = "Veuillez vous connecter pour ajouter des articles au panier.";
            redirect('index.php?action=login');
            exit;
        }

        // Traitement du formulaire d'ajout
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = $_POST['product_id'] ?? null;
            $quantity = intval($_POST['quantity'] ?? 1);

            // Vérifie que le produit et la quantité sont valides
            if ($product_id && $quantity > 0) {
                $productModel = new Product();
                $product = $productModel->getById($product_id);

                if ($product) {
                    // Initialise le panier s'il n'existe pas
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }

                    // Vérifie si le produit est déjà dans le panier
                    $found = false;
                    foreach ($_SESSION['cart'] as &$item) {
                        if ($item['id'] == $product_id) {
                            // Si oui, augmente la quantité
                            $item['quantity'] += $quantity;
                            $found = true;
                            break;
                        }
                    }

                    // Si non, ajoute le nouveau produit
                    if (!$found) {
                        $_SESSION['cart'][] = [
                            'id' => $product['id'],
                            'name' => $product['name'],
                            'price' => $product['price'],
                            'image' => $product['image'],
                            'quantity' => $quantity
                        ];
                    }

                    $_SESSION['success'] = "Produit ajouté au panier !";
                    redirect('index.php?action=cart');
                }
            }
        }

        redirect('index.php?action=catalogue');
    }

    /**
     * Retire un produit du panier
     */
    public function remove()
    {
        // Autoriser l'admin à vider son panier (même s'il ne peut pas acheter)
        $product_id = $_GET['id'] ?? null;

        if ($product_id && isset($_SESSION['cart'])) {
            // Filtre le panier pour retirer le produit spécifique
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($product_id) {
                return $item['id'] != $product_id;
            });

            $_SESSION['success'] = "Produit retiré du panier.";
        }

        redirect('index.php?action=cart');
    }

    /**
     * Traite la validation de la commande
     */
    public function checkout()
    {
        // BLOQUER COMPLÈTEMENT LE CHECKOUT POUR L'ADMIN
        if (isAdmin()) {
            $_SESSION['error'] = "Les administrateurs ne peuvent pas passer de commandes. Veuillez créer un compte client séparé.";
            redirect('index.php?action=catalogue');
            exit;
        }

        // Vérifications de sécurité
        if (!isLoggedIn()) {
            redirect('index.php?action=login');
        }

        if (empty($_SESSION['cart'])) {
            redirect('index.php?action=cart');
        }

        $purchaseModel = new Purchase();
        $purchaseItemModel = new PurchaseItem();

        // Calcul du total final
        $total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Création de la commande en base de données
        if ($purchaseModel->create($_SESSION['user_id'], $total)) {
            $purchase_id = $purchaseModel->id;

            // Ajout de chaque article à la commande
            foreach ($_SESSION['cart'] as $item) {
                $purchaseItemModel->create($purchase_id, $item['id'], $item['quantity']);
            }

            // Vidage du panier après commande validée
            $_SESSION['cart'] = [];
            // Redirection vers la page de confirmation
            redirect('index.php?action=confirmation&id=' . $purchase_id);
        }

        redirect('index.php?action=cart');
    }

    /**
     * Affiche la page de confirmation de commande
     */
    public function confirmation()
    {
        // Empêcher l'admin d'accéder à la confirmation
        if (isAdmin()) {
            $_SESSION['error'] = "Accès non autorisé.";
            redirect('index.php?action=catalogue');
            exit;
        }

        if (!isLoggedIn()) {
            redirect('index.php?action=login');
        }

        // Récupération de l'ID de commande
        $purchase_id = $_GET['id'] ?? null;
        if (!$purchase_id) {
            redirect('index.php?action=home');
        }

        $purchaseModel = new Purchase();
        $purchase = $purchaseModel->getById($purchase_id);

        // Vérification que la commande appartient bien à l'utilisateur connecté
        if (!$purchase || $purchase['user_id'] != $_SESSION['user_id']) {
            redirect('index.php?action=home');
        }

        // Récupération des articles de la commande
        $purchaseItemModel = new PurchaseItem();
        $items = $purchaseItemModel->getByPurchaseId($purchase_id);

        // Affichage de la page de confirmation
        require_once 'views/header.php';
        require_once 'views/confirmation.php';
        require_once 'views/footer.php';
    }
}
