<?php

/**
 * Gère les commandes (purchases) en base
 * Tout ce qui concerne les commandes clients
 */
class Purchase
{
    private $conn;           // Lien vers la BDD
    private $table = 'purchase';  // Table des commandes

    // Infos d'une commande
    public $id;
    public $created_at;
    public $status;
    public $total_price;
    public $user_id;

    /**
     * Se connecte à la base dès qu'on crée un Purchase
     */
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Crée une nouvelle commande
     * Quand un client valide son panier
     */
    public function create($user_id, $total_price)
    {
        $query = "INSERT INTO " . $this->table . " 
                 SET user_id = :user_id, 
                     total_price = :total_price, 
                     status = 'pending',
                     created_at = NOW()";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":total_price", $total_price);

        if ($stmt->execute()) {
            // On récupère l'ID de la commande qu'on vient de créer
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Toutes les commandes d'un client
     * Pour la page "mes commandes"
     */
    public function getByUserId($user_id)
    {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE user_id = :user_id 
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Toutes les commandes de tous les clients
     * Pour l'admin
     */
    public function getAll()
    {
        $query = "SELECT p.*, u.firstname, u.lastname, u.email 
                  FROM " . $this->table . " p 
                  JOIN user u ON p.user_id = u.id 
                  ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Une commande précise avec ses infos
     * Inclut le nom du client pour l'admin
     */
    public function getById($id)
    {
        $query = "SELECT p.*, u.firstname, u.lastname, u.email 
                  FROM " . $this->table . " p 
                  JOIN user u ON p.user_id = u.id 
                  WHERE p.id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Change le statut d'une commande
     * Ex: pending → confirmed → shipped → completed
     */
    public function updateStatus($purchase_id, $status)
    {
        $query = "UPDATE " . $this->table . " 
                  SET status = :status 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $purchase_id);

        return $stmt->execute();
    }
}
