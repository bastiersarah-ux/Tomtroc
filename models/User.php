<?php

/**
 * Entité User : un user est défini par son id, pseudo, email, mot de passe, photo de profil et , et une date de création.
 */
class User extends AbstractEntity
{
    private string $username;
    private string $password;
    private string $email;
    private string $picture;
    private string $date;

    /**
     * Setter pour le pseudo.
     * @param string $username
     */
    public function setUserName(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Getter pour le pseudo.
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Setter pour l'email.
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Getter pour l'email.
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Setter pour le password.
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Getter pour le password.
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Setter pour la photo de profil.
     * @param string $picture
     */
    public function setPictureProfil(string $picture): void
    {
        $this->picture = $picture;
    }

    /**
     * Getter pour la photo de profil.
     * @return string
     */
    public function getPictureProfil(): string
    {
        return $this->picture;
    }

    /**
     * Setter pour la date de création du profil d'utilisateur.
     * @param string $date
     */
    public function setDateCreation(string $date): void
    {
        $this->date = $date;
    }

    /**
     * Getter pour la date de création du profil d'utilisateur.
     * @return string
     */
    public function getDateCreation(): string
    {
        return $this->date;
    }
}
