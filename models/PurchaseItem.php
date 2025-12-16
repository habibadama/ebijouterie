<?php

/**
 * Gère les articles des commandes
 * Chaque ligne d'une commande (quoi et combien)
 */
class PurchaseItem
{
    private $conn;                 // Lien vers la BDD
    private $table = 'purchase_item';  // Table des lignes de commande

    // Infos d'un article dans une commande
    public $id;
    public $quantity;
    public $purchase_id;
    public $product_id;

    /**
     * Se connecte à la base
     */
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Ajoute un produit à une commande
     * Une ligne = un produit avec sa quantité
     */
    public function create($purchase_id, $product_id, $quantity)
    {
        $query = "INSERT INTO " . $this->table . " 
                 SET purchase_id = :purchase_id, 
                     product_id = :product_id, 
                     quantity = :quantity";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":purchase_id", $purchase_id);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->bindParam(":quantity", $quantity);

        return $stmt->execute();
    }


    /**
     * Tous les articles d'une commande
     * Avec les infos du produit (nom, prix, image)
     */
    public function getByPurchaseId($purchase_id)
    {
        $query = "SELECT pi.*, p.name, p.price, p.image 
                  FROM " . $this->table . " pi
                  JOIN product p ON pi.product_id = p.id
                  WHERE pi.purchase_id = :purchase_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":purchase_id", $purchase_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Vérifie si un produit a déjà été commandé
     * Pour empêcher la suppression d'un produit avec historique
     */
    public function productHasOrders($product_id)
    {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE product_id = :product_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result['count'] > 0;
    }
}
