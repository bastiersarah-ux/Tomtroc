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
    private string $status;
    private ?string $picture;

    private string $slugUser;
    private string $username;
    private ?string $profilePicture;

    public function __construct(array $line)
    {
        $this->idBook = $line['id'];
        $this->title = $line['title'];
        $this->author = $line['author'];
        $this->description = $line['description'];
        $this->status = $line['status'];
        $this->picture = $line['picture'];

        $this->slugUser = $line['slug'];
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
     * @return string Le statut du livre (disponible ou non)
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Retourne le slug de l'utilisateur propriétaire du livre.
     *
     * @return string Le slug de l'utilisateur
     */
    public function getSlugUser(): string
    {
        return $this->slugUser;
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
     * @return string|null L'image du livre
     */
    public function getPicture(): ?string
    {
        return $this->picture ?? "";
    }

    /**
     * Retourne la photo de profil de l'utilisateur propriétaire du livre.
     *
     * @return ?string La photo de profil de l'utilisateur
     */
    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }
}
