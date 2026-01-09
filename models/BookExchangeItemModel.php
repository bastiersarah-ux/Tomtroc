<?php

/**
 * Classe qui gère les informations d'un livre à l'échange.
 */

class BookExchangeItemModel
{
    private int $idBook;
    private string $title;
    private string $author;
    private string $description;
    private bool $status;
    private string $picture;

    private int $idUser;
    private string $username;
    private string $profilePicture;

    public function __construct(array $line)
    {
        $this->idBook = $line['id'];
        $this->title = $line['title'];
        $this->author = $line['author'];
        $this->description = $line['description'];
        $this->status = $line['status'];
        $this->picture = $line['picture'];

        $this->idUser = $line['id_user'];
        $this->username = $line['username'];
        $this->profilePicture = $line['profile_picture'];
    }

    /**
     * GETTERS
     */

    /**
     * Retourne l'identifiant du livre.
     *
     * @return int L'ID du livre
     */
    public function getIdBook(): int
    {
        return $this->idBook;
    }

    /**
     * Retourne le titre du livre.
     *
     * @return string Le titre du livre
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Retourne l'auteur du livre.
     *
     * @return string L'auteur du livre
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Retourne la description du livre.
     *
     * @return string La description du livre
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Retourne le statut du livre.
     *
     * @return bool Le statut du livre (disponible ou non)
     */
    public function getStatus(): bool
    {
        return $this->status;
    }

    /**
     * Retourne l'identifiant de l'utilisateur propriétaire du livre.
     *
     * @return int L'ID de l'utilisateur
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * Retourne le pseudo de l'utilisateur propriétaire du livre.
     *
     * @return string Le pseudo de l'utilisateur
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Retourne l'image du livre.
     *
     * @return string L'image du livre
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * Retourne la photo de profil de l'utilisateur propriétaire du livre.
     *
     * @return string La photo de profil de l'utilisateur
     */
    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    /**
     * SETTERS
     */

    /**
     * Définit l'identifiant du livre.
     *
     * @param int $idBook L'ID du livre
     * @return void
     */
    public function setIdBook(int $idBook): void
    {
        $this->idBook = $idBook;
    }

    /**
     * Définit le titre du livre.
     *
     * @param string $title Le titre du livre
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Définit l'auteur du livre.
     *
     * @param string $author L'auteur du livre
     * @return void
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * Définit la description du livre.
     *
     * @param string $description La description du livre
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Définit le statut du livre.
     *
     * @param bool $status Le statut du livre (disponible ou non)
     * @return void
     */
    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    /**
     * Définit l'identifiant de l'utilisateur propriétaire du livre.
     *
     * @param int $idUser L'ID de l'utilisateur
     * @return void
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * Définit le pseudo de l'utilisateur propriétaire du livre.
     *
     * @param string $username Le pseudo de l'utilisateur
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Définit l'image du livre.
     *
     * @param string $picture L'image du livre
     * @return void
     */
    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }

    /**
     * Définit la photo de profil de l'utilisateur propriétaire du livre.
     *
     * @param string $profilePicture La photo de profil de l'utilisateur
     * @return void
     */
    public function setProfilePicture(string $profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }
}
