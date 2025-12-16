<?php

/**
 * Classe de gestion de la connexion à la base de données
 * Utilise le pattern Singleton pour une seule connexion
 */
class Database
{
    public $conn;  // Stocke la connexion PDO

    /**
     * Crée et retourne la connexion à la base de données
     * Utilise le pattern Singleton pour éviter les connexions multiples
     * @return PDO Objet de connexion PDO
     */
    public function getConnection()
    {
        // Si pas encore connecté, établit la connexion
        if ($this->conn === null) {
            try {
                // Création de la connexion PDO avec paramètres
                $this->conn = new PDO(
                    // Chaîne de connexion : serveur, base, encodage
                    "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                    DB_USER,     // Nom d'utilisateur MySQL
                    DB_PASS,     // Mot de passe MySQL
                    // Options de configuration PDO
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // Génère des exceptions en cas d'erreur
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC    // Retourne les résultats en tableau associatif
                    ]
                );
            } catch (PDOException $exception) {
                // En cas d'erreur, affiche le message et arrête l'application
                die("Erreur de connexion: " . $exception->getMessage());
            }
        }
        // Retourne la connexion existante ou nouvellement créée
        return $this->conn;
    }
}
