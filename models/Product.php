<?php

/**
 * Gère les produits en base de données
 * Tout ce qui concerne les produits : ajout, modif, recherche, etc.
 */
class Product
{
    private $conn;        // Lien vers la BDD
    private $table = "product";  // Table des produits

    /**
     * Se connecte à la base dès qu'on crée un Product
     */
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // =====================
    // AFFICHAGE DES PRODUITS
    // =====================

    /**
     * Récupère tous les produits en vente
     * Les produits archivés ou désactivés ne sont pas inclus
     */
    public function getAll()
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN category c ON p.category_id = c.id 
                  WHERE p.status = 'active' AND p.archived_at IS NULL
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Cherche un produit précis avec son ID
     * Retourne null si pas trouvé
     */
    public function getById($id)
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN category c ON p.category_id = c.id 
                  WHERE p.id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Tous les produits d'une catégorie
     * Utile pour filtrer le catalogue
     */
    public function getByCategory($category_id)
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN category c ON p.category_id = c.id 
                  WHERE p.category_id = ? 
                  AND p.status = 'active' AND p.archived_at IS NULL
                  ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $category_id);
        $stmt->execute();
        return $stmt;
    }

    // =====================
    // RECHERCHE
    // =====================

    /**
     * Recherche dans les noms, descriptions et catégories
     * Le % autour des keywords permet de chercher des parties de mots
     */
    public function search($keywords, $category_id = null)
    {
        $searchTerm = "%" . $keywords . "%";

        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN category c ON p.category_id = c.id 
                  WHERE (p.name LIKE :keywords 
                         OR p.description LIKE :keywords 
                         OR c.name LIKE :keywords)
                  AND p.status = 'active' 
                  AND p.archived_at IS NULL
                  ORDER BY p.id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":keywords", $searchTerm);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Compte combien de résultats on a dans une recherche
     * Pour savoir combien de pages afficher
     */
    public function getSearchCount($keywords, $category_id = null)
    {
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table . " p 
                  LEFT JOIN category c ON p.category_id = c.id 
                  WHERE (p.name LIKE :keywords 
                         OR p.description LIKE :keywords 
                         OR c.name LIKE :keywords)
                  AND p.status = 'active' 
                  AND p.archived_at IS NULL";

        $stmt = $this->conn->prepare($query);
        $searchTerm = "%" . $keywords . "%";
        $stmt->bindParam(":keywords", $searchTerm);
        $stmt->execute();

        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    // =====================
    // PAGINATION
    // =====================

    /**
     * Récupère X produits à partir de la position Y
     * Pour la pagination du catalogue
     */
    public function getPaginated($offset, $limit)
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN category c ON p.category_id = c.id 
                  WHERE p.status = 'active' AND p.archived_at IS NULL
                  ORDER BY p.id DESC 
                  LIMIT :limit OFFSET :offset";

        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Compte tous les produits actifs
     * Pour calculer le nombre de pages
     */
    public function getTotalCount()
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                  WHERE status = 'active' AND archived_at IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    /**
     * Combien de produits dans chaque catégorie
     * Pour afficher les compteurs dans le menu
     */
    public function getCountByCategories()
    {
        $query = "SELECT category_id, COUNT(*) as count 
              FROM " . $this->table . " 
              WHERE status = 'active' AND archived_at IS NULL
              GROUP BY category_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        // Format pratique : [id_catégorie => nombre]
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    // =====================
    // GESTION DES STOCKS
    // =====================

    /**
     * Les produits qui bientôt en rupture
     * Seuil à 5 par défaut mais on peut changer
     */
    public function getLowStockProducts($threshold = 5)
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN category c ON p.category_id = c.id 
                  WHERE p.stock <= ? AND p.stock > 0
                  AND p.status = 'active' AND p.archived_at IS NULL
                  ORDER BY p.stock ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $threshold);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // =====================
    // ARCHIVAGE (SUPPRESSION LOGIQUE)
    // =====================

    /**
     * Désactive un produit sans le supprimer
     * Comme ça on garde l'historique des commandes
     */
    public function archive($id)
    {
        $query = "UPDATE " . $this->table . " 
                 SET status = 'archived', archived_at = NOW() 
                 WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    /**
     * Remet un produit archivé en vente
     */
    public function restore($id)
    {
        $query = "UPDATE " . $this->table . " 
                 SET status = 'active', archived_at = NULL 
                 WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    /**
     * Tous les produits, même archivés
     * Uniquement pour l'admin
     */
    public function getAllForAdmin()
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN category c ON p.category_id = c.id 
                  ORDER BY p.status = 'active' DESC, p.id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Juste les produits archivés
     * Pour les restaurer si besoin
     */
    public function getArchived()
    {
        $query = "SELECT p.*, c.name as category_name 
                  FROM " . $this->table . " p 
                  LEFT JOIN category c ON p.category_id = c.id 
                  WHERE p.status = 'archived' AND p.archived_at IS NOT NULL
                  ORDER BY p.archived_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Combien de produits sont archivés
     * Pour l'affichage dans l'admin
     */
    public function getArchivedCount()
    {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                  WHERE status = 'archived' AND archived_at IS NOT NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }

    // =====================
    // AJOUT ET MODIFICATION
    // =====================

    /**
     * Ajoute un nouveau produit
     * Les données viennent du formulaire admin
     */
    public function create($data)
    {
        $query = "INSERT INTO " . $this->table . " 
                  (name, price, category_id, description, image, stock, created_at, status) 
                  VALUES (:name, :price, :category_id, :description, :image, :stock, NOW(), 'active')";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":category_id", $data['category_id']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":image", $data['image']);
        $stmt->bindParam(":stock", $data['stock']);

        return $stmt->execute();
    }

    /**
     * Modifie un produit existant
     * Met à jour aussi la date de modification
     */
    public function update($id, $data)
    {
        $query = "UPDATE " . $this->table . " 
                  SET name = :name, price = :price, category_id = :category_id, 
                      description = :description, image = :image, stock = :stock,
                      updated_at = NOW()
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $data['name']);
        $stmt->bindParam(":price", $data['price']);
        $stmt->bindParam(":category_id", $data['category_id']);
        $stmt->bindParam(":description", $data['description']);
        $stmt->bindParam(":image", $data['image']);
        $stmt->bindParam(":stock", $data['stock']);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }
}
