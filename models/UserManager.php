<?php

/**
 * Classe UserManager pour gérer les requêtes liées aux users et à l'authentification.
 */

class UserManager extends AbstractEntityManager
{

    /**
     * Récupère un utilisateur par son identifiant.
     * @param string $id : l'identifiant de l'utilisateur.
     * @return User|null : l'objet User ou null si non trouvé.
     */
    public function getUserById(string $id): ?User
    {
        $sql = "SELECT `id`, `username`, `email`, `password`, `date_creation`, `profile_picture` FROM user WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $user = $result->fetch();
        if ($id) {
            return new User($user);
        }
        return null;
    }

    /**
     * Récupère un utilisateur par son adresse email.
     * @param string $email : l'adresse email de l'utilisateur.
     * @return User|null : l'objet User ou null si non trouvé.
     */
    public function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT `id`, `username`, `email`, `password`, `date_creation`, `profile_picture` FROM user WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        $user = $result->fetch();
        if ($user) {
            return new User($user);
        }
        return null;
    }

    /**
     * Vérifie si l'adresse email est déjà utilisée par un utilisateur.
     * @param string $email : l'adresse email à vérifier.
     * @return bool : true si l'email est déjà utilisé, false sinon.
     */
    public function checkIfEmailUsed(string $email): bool
    {
        $sql = "SELECT 1 FROM user WHERE UPPER(email) = UPPER(:email)";
        $result = $this->db->query($sql, ['email' => $email]);

        return $result->rowCount() > 0;
    }

    /**
     * Vérifie si le nom d'utilisateur est déjà utilisé par un autre utilisateur.
     * @param string $username : le nom d'utilisateur à vérifier.
     * @return bool : true si le nom d'utilisateur est déjà utilisé, false sinon.
     */
    public function checkIfUsernameUsed(string $username): bool
    {
        $sql = "SELECT 1 FROM user WHERE UPPER(username) = UPPER(:username)";
        $result = $this->db->query($sql, ['username' => $username]);

        return $result->rowCount() > 0;
    }

    /**
     * Enregistre un nouvel utilisateur dans la base de données.
     * @param string $email : l'adresse email de l'utilisateur.
     * @param string $username : le nom d'utilisateur.
     * @param string $password : le mot de passe en clair (sera hashé).
     * @param string $slug : le slug unique de l'utilisateur.
     * @return int|null : l'ID du nouvel utilisateur ou null en cas d'échec.
     */
    public function registerUser(string $email, string $username, string $password, string $slug): ?int
    {
        $sql = "INSERT INTO user (username, email, password, slug, date_creation) VALUES (:username, :email, :password, :slug, NOW())";
        $result = $this->db->query($sql, [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'slug' => $slug
        ]);
        if ($result->rowCount() == 0) {
            return null;
        }
        return $this->db->getPDO()->lastInsertId();
    }

    /**
     * Met à jour les informations d'un utilisateur existant.
     * @param int $id : l'identifiant de l'utilisateur à mettre à jour.
     * @param string $email : la nouvelle adresse email.
     * @param string $username : le nouveau nom d'utilisateur.
     * @param string $password : le nouveau mot de passe (hashé).
     * @param string $slug : le nouveau slug unique.
     * @param string $filename : le chemin de la nouvelle photo de profil.
     * @return void
     */
    public function updateUser(int $id, string $email, string $username, string $password, string $slug, string $filename): void
    {
        $sql = "UPDATE user SET username = :username, email = :email, password = :password, profile_picture = :profile_picture, slug = :slug WHERE id = :id";
        $this->db->query($sql, [
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'slug' => $slug,
            'profile_picture' => $filename,
            'id' => $id
        ]);
    }

    /**
     * Récupère un utilisateur par son slug (identifiant URL-friendly).
     * @param string $slug : le slug de l'utilisateur.
     * @return User|null : l'objet User ou null si non trouvé.
     */
    public function getUserBySlug(string $slug): ?User
    {
        $sql = "SELECT * FROM user WHERE slug = :slug";
        $result = $this->db->query($sql, ['slug' => $slug]);
        $user = $result->fetch();
        if (empty($user)) {
            return null;
        }
        return new User($user);
    }
}
