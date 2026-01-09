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
     * Récupère un user par son email.
     * @param string $email
     * @return ?User
     */
    public function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT `id`, `username`, `email`, `password`, `date_creation`, `profile_picture` FROM user WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        $user = $result->fetch();
        if (empty($user)) {
            return null;
        }
        return new User($user);
    }

    /**
     * Enregistre les données utilisateur.
     * @param string $email
     * @param string $username
     * @param string $password
     * @return int|null
     */
    public function registerUser(string $email, string $username, string $password): ?int
    {
        $sql = "INSERT INTO user (username, email, password, date_creation) VALUES (:username, :email, :password, NOW())";
        $result = $this->db->query($sql, [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
        if ($result->rowCount()  == 0) {
            return null;
        }
        return $this->db->getPDO()->lastInsertId();
    }

    public function updateUser(User $user): void
    {
        $sql = "UPDATE user SET username = :username, email = :email, password = :password, profile_picture = :profile_picture WHERE id = :id";
        $this->db->query($sql, [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'profile_picture' => $user->getProfilePicture(),
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
