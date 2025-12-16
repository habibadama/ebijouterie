<?php

/**
 * Contrôleur pour la gestion des utilisateurs
 * Gère l'inscription, connexion, profil et commandes des clients
 */
class UserController
{
    private $userModel;

    public function __construct()
    {
        // Initialise le modèle utilisateur pour toutes les méthodes
        $this->userModel = new User();
    }

    /**
     * Gère l'inscription d'un nouveau client
     */
    public function register()
    {
        $error = '';
        $success = '';

        // Traitement du formulaire d'inscription
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $firstname = $_POST['firstname'] ?? '';
            $lastname = $_POST['lastname'] ?? '';

            // Validation des champs obligatoires
            if (empty($email) || empty($password) || empty($firstname) || empty($lastname)) {
                $error = "Tous les champs sont obligatoires";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Format d'email invalide";
            } else {
                // Préparation des données pour l'inscription
                $this->userModel->email = $email;
                $this->userModel->password = $password;
                $this->userModel->firstname = $firstname;
                $this->userModel->lastname = $lastname;

                // Vérifie si l'email existe déjà
                if ($this->userModel->emailExists()) {
                    $error = "Cet email est déjà utilisé";
                } elseif ($this->userModel->register()) {
                    $success = "Inscription réussie ! Vous pouvez vous connecter";
                } else {
                    $error = "Erreur lors de l'inscription";
                }
            }
        }

        // Affichage du formulaire d'inscription
        require_once 'views/header.php';
        require_once 'views/register.php';
        require_once 'views/footer.php';
    }

    /**
     * Gère la connexion des utilisateurs
     */
    public function login()
    {
        $error = '';

        // Traitement du formulaire de connexion
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $error = "Email et mot de passe requis";
            } else {
                $this->userModel->email = $email;
                $this->userModel->password = $password;

                // Tentative de connexion
                if ($this->userModel->login()) {
                    // Stocke les informations utilisateur en session
                    $_SESSION['user_id'] = $this->userModel->id;
                    $_SESSION['user_email'] = $this->userModel->email;
                    $_SESSION['user_firstname'] = $this->userModel->firstname;
                    $_SESSION['user_lastname'] = $this->userModel->lastname;
                    $_SESSION['user_roles'] = $this->userModel->roles;

                    // Redirige vers la page d'accueil
                    redirect('index.php?action=home');
                } else {
                    $error = "Email ou mot de passe incorrect";
                }
            }
        }

        // Affichage du formulaire de connexion
        require_once 'views/header.php';
        require_once 'views/login.php';
        require_once 'views/footer.php';
    }

    /**
     * Déconnecte l'utilisateur et détruit la session
     */
    public function logout()
    {
        session_destroy();
        redirect('index.php?action=home');
    }

    /**
     * Affiche et gère la modification du profil utilisateur
     */
    public function profile()
    {
        // Vérifie que l'utilisateur est connecté
        if (!isLoggedIn()) {
            redirect('index.php?action=login');
        }

        $error = '';
        $success = '';
        $passwordError = '';
        $passwordSuccess = '';

        // Charge les données de l'utilisateur depuis la base
        $userData = $this->userModel->getById($_SESSION['user_id']);

        // Valeurs par défaut si utilisateur non trouvé
        if (!$userData) {
            $error = "Utilisateur non trouvé";
            $userData = [
                'firstname' => 'Non renseigné',
                'lastname' => 'Non renseigné',
                'email' => 'Non renseigné',
                'created_at' => date('Y-m-d H:i:s')
            ];
        }

        // Traitement du formulaire de mise à jour
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Section informations personnelles
            if (isset($_POST['email']) && isset($_POST['firstname']) && isset($_POST['lastname'])) {
                $email = $_POST['email'] ?? '';
                $firstname = $_POST['firstname'] ?? '';
                $lastname = $_POST['lastname'] ?? '';

                $this->userModel->id = $_SESSION['user_id'];
                $this->userModel->email = $email;
                $this->userModel->firstname = $firstname;
                $this->userModel->lastname = $lastname;

                if ($this->userModel->update()) {
                    // Met à jour la session avec les nouvelles données
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_firstname'] = $firstname;
                    $success = "Profil mis à jour avec succès";

                    // Recharge les données depuis la base
                    $userData = $this->userModel->getById($_SESSION['user_id']);
                } else {
                    $error = "Erreur lors de la mise à jour";
                }
            }

            // Section changement de mot de passe
            if (isset($_POST['current_password'])) {
                $currentPassword = $_POST['current_password'] ?? '';
                $newPassword = $_POST['new_password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';

                if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                    $passwordError = "Tous les champs sont obligatoires";
                } elseif ($newPassword !== $confirmPassword) {
                    $passwordError = "Les nouveaux mots de passe ne correspondent pas";
                } elseif (strlen($newPassword) < 6) {
                    $passwordError = "Le mot de passe doit contenir au moins 6 caractères";
                } else {
                    $this->userModel->id = $_SESSION['user_id'];
                    if ($this->userModel->changePassword($currentPassword, $newPassword)) {
                        $passwordSuccess = "Mot de passe modifié avec succès";
                    } else {
                        $passwordError = "Mot de passe actuel incorrect";
                    }
                }
            }
        }

        // Passe les données à la vue
        $user = (object)$userData;

        require_once 'views/header.php';
        require_once 'views/profile.php';
        require_once 'views/footer.php';
    }

    /**
     * Affiche les commandes de l'utilisateur connecté
     */
    public function myOrders()
    {
        if (!isLoggedIn()) {
            redirect('index.php?action=login');
            return;
        }

        // Récupère toutes les commandes de l'utilisateur
        $purchaseModel = new Purchase();
        $orders = $purchaseModel->getByUserId($_SESSION['user_id']);

        // Calcule les statistiques des commandes
        $ordersSummary = $this->calculateOrdersSummary($orders);

        // Charge les articles pour chaque commande
        $purchaseItemModel = new PurchaseItem();
       
        foreach ($orders as &$order) {
        // Récupère les articles de la commande
             $order['items'] = (new PurchaseItem())->getByPurchaseId($order['id']);

        // Calcule si la commande peut être annulée
            $createdAt = new DateTime($order['created_at']); // date de création
            $now = new DateTime(); // date actuelle
            $interval = $now->getTimestamp() - $createdAt->getTimestamp();

        // 3600 secondes = 1 heure
            $order['can_cancel'] = ($interval <= 3600 && $order['status'] === 'pending');
        }

        require_once 'views/header.php';
        require_once 'views/my-orders.php';
        require_once 'views/footer.php';
    }

    /**
     * Calcule les statistiques des commandes
     * @param array $orders Liste des commandes
     * @return array Statistiques (total, montant, en attente, terminées)
     */
    private function calculateOrdersSummary($orders)
    {
        return [
            'total_orders' => count($orders),
            'total_amount' => array_sum(array_column($orders, 'total_price')),
            'pending_count' => count(array_filter($orders, function ($order) {
                return $order['status'] == 'pending';
            })),
            'completed_count' => count(array_filter($orders, function ($order) {
                return $order['status'] == 'completed';
            }))
        ];
    }

    /**
     * Permet à un client d'annuler sa commande
     * Conditions : commande en attente et dans les 1 heure
     */
    public function cancelOrder()
    {
        if (!isLoggedIn()) {
            redirect('index.php?action=login');
            exit;
        }

        $orderId = $_GET['id'] ?? null;
        if (!$orderId) {
            $_SESSION['error'] = "Commande non spécifiée";
            redirect('index.php?action=my-orders');
            exit;
        }

        $purchaseModel = new Purchase();
        $order = $purchaseModel->getById($orderId);

        // Vérifications de sécurité
        if (!$order) {
            $_SESSION['error'] = "Commande non trouvée";
            redirect('index.php?action=my-orders');
            exit;
        }

        // Vérifie que la commande appartient bien à l'utilisateur
        if ($order['user_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = "Accès non autorisé";
            redirect('index.php?action=my-orders');
            exit;
        }

        // Vérifie que la commande peut être annulée (uniquement "pending")
        if ($order['status'] != 'pending') {
            $_SESSION['error'] = "Cette commande ne peut plus être annulée (statut: " . $order['status'] . ")";
            redirect('index.php?action=my-orders');
            exit;
        }

        // Vérifie le délai d'annulation (1 heure maximum)
        $orderTime = strtotime($order['created_at']);
        $currentTime = time();
        $timeLimit = 3600; // 1 heure en secondes

        if (($currentTime - $orderTime) > $timeLimit) {
            $_SESSION['error'] = "Délai d'annulation dépassé (1 heure maximum)";
            redirect('index.php?action=my-orders');
            exit;
        }

        // Annule la commande en changeant son statut
        if ($purchaseModel->updateStatus($orderId, 'cancelled')) {
            $_SESSION['success'] = "Commande #{$orderId} annulée avec succès";
        } else {
            $_SESSION['error'] = "Erreur lors de l'annulation";
        }

        redirect('index.php?action=my-orders');
    }
}
