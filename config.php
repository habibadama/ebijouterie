<?php
// =============================================================================
// CONFIGURATION DU SITE
// =============================================================================

// 1. PARAMÈTRES DE LA BASE DE DONNÉES
// À modifier selon l'hébergement
define('DB_HOST', 'localhost');
define('DB_NAME', 'ebijouterie_db');
define('DB_USER', 'root');
define('DB_PASS', '');

// 2. DÉMARRAGE DE LA SESSION
// Pour garder l'utilisateur connecté
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. CHARGEMENT AUTOMATIQUE DES CLASSES
// Plus besoin de require partout
spl_autoload_register(function ($class) {
    if (file_exists('models/' . $class . '.php')) {
        require_once 'models/' . $class . '.php';
    }
    if (file_exists('controllers/' . $class . '.php')) {
        require_once 'controllers/' . $class . '.php';
    }
});

// 4. FONCTIONS UTILES POUR TOUT LE SITE

/**
 * Redirige vers une page
 * Utilisé après un formulaire pour éviter le rechargement
 */
function redirect($url)
{
    header('Location: ' . $url);
    exit;
}

/**
 * Vérifie si quelqu'un est connecté
 * Pour afficher/masquer des boutons
 */
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

/**
 * Vérifie si c'est un administrateur
 * Pour accéder au back-office
 */
function isAdmin()
{
    return isset($_SESSION['user_roles']) &&
        is_array($_SESSION['user_roles']) &&
        in_array('ROLE_ADMIN', $_SESSION['user_roles']);
}

/**
 * Vérifie si l'utilisateur peut acheter
 * Les admins ne peuvent pas passer commande
 */
function canMakePurchase()
{
    // Les admins ne peuvent pas acheter, seulement les clients normaux
    return isLoggedIn() && !isAdmin();
}

/**
 * Formate un prix en euros
 * Ex: 25.5 → "25,50 €"
 */
function formatPrice($price)
{
    // Si le prix est vide ou pas un nombre, on met 0
    if ($price === null || $price === '' || !is_numeric($price)) {
        $price = 0;
    }

    // Format français : virgule pour les centimes, espace pour les milliers
    return number_format(floatval($price), 2, ',', ' ') . ' €';
}

/**
 * Nettoie une chaîne de caractères
 * Pour éviter les injections dans les formulaires
 */
function sanitize($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}
