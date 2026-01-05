<?php

/**
 * Entité Book, un livre est défini par les champs
 * id, id_user, title, author, description, status, picture, date_creation
 */
class Book extends AbstractEntity
{
    private int $idUser;
    private string $title = "";
    private string $author = "";
    private string $description = "";
    private string $status = "";
    private string $picture = "";
    private ?DateTime $dateCreation = null;

    /**
     * Setter pour l'id de l'utilisateur. 
     * @param int $idUser
     */
    public function setIdUser(int $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * Getter pour l'id de l'utilisateur.
     * @return int
     */
    public function getIdUser(): int
    {
        return $this->idUser;
    }

    /**
     * Setter pour le titre.
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Getter pour le titre.
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Setter pour l'auteur.
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * Getter pour l'auteur.
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Setter pour la description.
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Getter pour la description.
     * @return string description
     */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * Setter pour le statut du livre.
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * Getter pour le statut du livre.
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * Setter pour l'image du livre.
     * @param string $picture
     */
    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }

    /**
     * Getter pour l'image du livre.
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * Setter pour la date de création d'un livre.
     * @param DateTime $dateCreation
     */
    public function setDateCreation(DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * Getter pour la date de création d'un livre.
     * @return DateTime
     */
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }
}
