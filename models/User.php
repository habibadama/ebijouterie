<?php

/**
 * Gère les utilisateurs du site
 * Clients et administrateurs
 */
class User
{
    private $conn;           // Lien vers la BDD
    private $table = 'user'; // Table des utilisateurs

    // Infos d'un utilisateur
    public $id;
    public $email;
    public $password;
    public $firstname;
    public $lastname;
    public $roles;
    public $created_at;

    /**
     * Se connecte à la base
     */
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Inscription d'un nouveau client
     * Le mot de passe est hashé pour la sécurité
     */
    public function register()
    {
        $query = "INSERT INTO " . $this->table . " 
                 SET email = :email, password = :password, 
                     firstname = :firstname, lastname = :lastname, 
                     roles = '[\"ROLE_USER\"]'";

        $stmt = $this->conn->prepare($query);

        // Nettoyage des données pour éviter les injections
        $this->email = sanitize($this->email);
        $this->firstname = sanitize($this->firstname);
        $this->lastname = sanitize($this->lastname);
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Connexion d'un utilisateur
     * Vérifie l'email puis le mot de passe hashé
     */
    public function login()
    {
        $query = "SELECT id, email, password, roles, firstname, lastname, created_at 
                 FROM " . $this->table . " 
                 WHERE email = :email 
                 LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();

            // Compare le mot de passe saisi avec le hash en base
            if (password_verify($this->password, $row['password'])) {
                $this->id = $row['id'];
                $this->email = $row['email'];
                $this->roles = json_decode($row['roles'], true);
                $this->firstname = $row['firstname'];
                $this->lastname = $row['lastname'];
                $this->created_at = $row['created_at'];
                return true;
            }
        }
        return false;
    }

    /**
     * Vérifie si un email est déjà utilisé
     * Pour éviter les doublons à l'inscription
     */
    public function emailExists()
    {
        $query = "SELECT id FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /**
     * Met à jour le profil utilisateur
     * Email, prénom, nom mais pas le mot de passe
     */
    public function update()
    {
        $query = "UPDATE " . $this->table . " 
                 SET email = :email, firstname = :firstname, lastname = :lastname 
                 WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->email = sanitize($this->email);
        $this->firstname = sanitize($this->firstname);
        $this->lastname = sanitize($this->lastname);

        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":firstname", $this->firstname);
        $stmt->bindParam(":lastname", $this->lastname);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    /**
     * Change le mot de passe
     * Vérifie d'abord l'ancien mot de passe
     */
    public function changePassword($currentPassword, $newPassword)
    {
        // 1. Vérifier que l'ancien mot de passe est bon
        $query = "SELECT password FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();

        $user = $stmt->fetch();

        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return false;
        }

        // 2. Hasher et sauvegarder le nouveau
        $query = "UPDATE " . $this->table . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    /**
     * Récupère un utilisateur par son ID
     * Sans le mot de passe pour la sécurité
     */
    public function getById($id)
    {
        $query = "SELECT id, email, firstname, lastname, roles, created_at 
                  FROM " . $this->table . " 
                  WHERE id = :id 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            return $stmt->fetch();
        }
        return false;
    }

    /**
     * Tous les utilisateurs du site
     * Pour l'administration
     */
    public function getAllUsers()
    {
        $query = "SELECT id, email, firstname, lastname, roles, created_at 
                  FROM " . $this->table . " 
                  ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
