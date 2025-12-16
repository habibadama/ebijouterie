<?php

// test_simple.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Définissez les constantes MANUELLEMENT si config.php n'existe pas
define('DB_HOST', 'localhost');
define('DB_NAME', 'ebijouterie_db');
define('DB_USER', 'root');
define('DB_PASS', '');


// 2. Connexion PDO directe
try {
    
    $conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,       
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC   
        ]
        );
    
    echo "✓ Connexion réussie à " . DB_NAME . "<br><br>";
    
    // 3. Requête directe
    $sql = "SELECT id, name, price FROM product";
    echo "Exécution: $sql<br><br>";
    
    $stmt = $conn->query($sql);
    $products = $stmt->fetchAll();
    
    echo "Nombre de produits: " . count($products) . "<br><br>";
    
    // 4. Afficher
    if (count($products) > 0) {
        echo "<h3>LISTE DES PRODUITS:</h3>";
        foreach ($products as $product) {
            echo "ID: {$product['id']} - ";
            echo "Nom: " . htmlspecialchars($product['name']) . " - ";
            echo "Prix: {$product['price']}€<br>";
        }
    } else {
        echo "<h3 style='color: red'>AUCUN PRODUIT TROUVÉ</h3>";
        echo "Vérifiez que :<br>";
        echo "1. La table 'product' existe<br>";
        echo "2. Elle contient des données<br>";
        echo "3. Vous êtes connecté à la bonne base: " . DB_NAME . "<br>";
    }
    
} catch (PDOException $e) {
    echo "<h3 style='color: red'>ERREUR DE CONNEXION:</h3>";
    echo $e->getMessage() . "<br>";
    
    // Suggestions
    if (strpos($e->getMessage(), 'Unknown database') !== false) {
        echo "<br>La base '" . DB_NAME . "' n'existe pas.<br>";
        echo "Créez-la avec: CREATE DATABASE " . DB_NAME . ";";
    }
}