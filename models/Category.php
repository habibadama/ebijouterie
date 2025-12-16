<?php

/**
 * Modèle pour la gestion des catégories de produits
 * Gère les opérations CRUD sur la table 'category'
 */
class Category
{
    private $conn;       // Connexion à la base de données
    private $table = "category";  // Nom de la table

    /**
     * Initialise la connexion à la base de données
     */
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Récupère toutes les catégories triées par nom
     * @return PDOStatement Résultat de la requête
     */
    public function getAll()
    {
        $query = "SELECT * FROM `category` ORDER BY `name`";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Récupère une catégorie par son ID
     * @param int $id ID de la catégorie
     * @return array|null Données de la catégorie ou null si non trouvée
     */
    public function getById($id)
    {
        $query = "SELECT * FROM `category` WHERE `id` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch();  // Retourne une seule ligne
    }

    /**
     * Récupère une catégorie par son nom
     * @param string $name Nom de la catégorie
     * @return array|null Données de la catégorie ou null si non trouvée
     */
    public function getByName($name)
    {
        $query = "SELECT * FROM `category` WHERE `name` = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $name);
        $stmt->execute();
        return $stmt->fetch();  // Retourne une seule ligne
    }
}
