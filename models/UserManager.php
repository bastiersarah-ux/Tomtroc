<?php

/**
 * Classe UserManager pour gérer les requêtes liées aux users et à l'authentification.
 */

class UserManager extends AbstractEntityManager
{

    /**
     * Récupère un user par son id.
     * @param string $id
     * @return ?User
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
     * Récupère un user par son pseudo.
     * @param string $username
     * @return ?User
     */
    public function getUserByUserName(string $username): ?User
    {
        $sql = "SELECT `id`, `username`, `email`, `password`, `date_creation`, `profile_picture` FROM user WHERE username = :username";
        $result = $this->db->query($sql, ['username' => $username]);
        $user = $result->fetch();
        if ($user) {
            return new User($user);
        }
        return null;
    }

    /**
     * Vérifie si l'email est déjà utilisé par un autre utilisateur.
     * @param string $email
     * @return bool
     */
    public function checkIfEmailUsed(string $email): bool
    {
        $sql = "SELECT 1 FROM user WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);

        return $result->rowCount() > 0;
    }

    /**
     * Enregistre les données utilisateur.
     * @param string $email
     * @param string $username
     * @param string $password
     * @param string $slug
     * @return int|null
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

    public function updateUser(string $email, string $username, string $password, string $slug): void
    {
        $sql = "UPDATE user SET username = :username, email = :email, password = :password, profile_picture = :profile_picture WHERE id = :id";
        $this->db->query($sql, [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'slug' => $slug
        ]);
    }

    public function getUserBySlug(string $slug): ?User
    {
        $sql = "SELECT * FROM users WHERE slug = :slug";
        $result = $this->db->query($sql, ['slug' => $slug]);
        $user = $result->fetch();
        if (empty($user)) {
            return null;
        }
        return new User($user);
    }
}
