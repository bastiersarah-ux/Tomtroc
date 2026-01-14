<?php

/**
 * Entité User : un user est défini par son id, pseudo, email, mot de passe, photo de profil et , et une date de création.
 */
class User extends AbstractEntity
{
    private string $username;
    private string $password;
    private string $email;
    private ?string $picture = null;
    private DateTime $dateCreation;

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
    public function getUserName(): string
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
    public function setProfilePicture(?string $picture): void
    {
        $this->picture = $picture;
    }

    /**
     * Getter pour la photo de profil.
     * @return ?string
     */
    public function getProfilePicture(): ?string
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
