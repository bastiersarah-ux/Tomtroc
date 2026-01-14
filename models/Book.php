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
     * Setter pour la date de création. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateCreation
     * @param string $format : le format pour la convertion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */
    public function setDateCreation(string|DateTime $dateCreation, string $format = 'Y-m-d H:i:s'): void
    {
        if (is_string($dateCreation)) {
            $dateCreation = DateTime::createFromFormat($format, $dateCreation);
        }
        $this->dateCreation = $dateCreation;
    }

    /**
     * Récupère la date de création.
     *
     * @return DateTime|null
     */
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }
}
