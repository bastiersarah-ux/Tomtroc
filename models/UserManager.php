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
        $sql = "SELECT `id`, `username`, `email`, `password`, `date_creation`, `profil_picture` FROM user WHERE id = :id";
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
        $sql = "SELECT `id`, `username`, `email`, `password`, `date_creation`, `profil_picture` FROM user WHERE username = :username";
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
        $sql = "SELECT `id`, `username`, `email`, `password`, `date_creation`, `profil_picture` FROM user WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        $user = $result->fetch();
        if ($email) {
            return new User($user);
        }
        return null;
    }

    /**
     * Enregistre les données utilisateur.
     * @param string $email
     * @param string $username
     * @param string $password
     * @return ?User
     */
    public function registerUser(string $email, string $username, string $password): bool
    {
        $sql = "INSERT INTO user (username, email, password, date_creation) VALUES (:username, :email, :password, NOW())";
        $result = $this->db->query($sql, [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);
        return $result->rowCount() > 0;
    }
}
