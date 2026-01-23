<?php

/**
 * Entité User : un utilisateur est défini par son id, pseudo, email, mot de passe, photo de profil, slug et date de création.
 */
class User extends AbstractEntity
{
    private string $username;
    private string $password;
    private string $email;
    private ?string $picture = null;
    private DateTime $dateCreation;
    private string $slug;

    /**
     * Setter pour le nom d'utilisateur.
     * @param string $username : le nom d'utilisateur (pseudo).
     */
    public function setUserName(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Getter pour le nom d'utilisateur.
     * @return string : le nom d'utilisateur (pseudo).
     */
    public function getUserName(): string
    {
        return $this->username;
    }

    /**
     * Setter pour l'adresse email de l'utilisateur.
     * @param string $email : l'adresse email.
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Getter pour l'adresse email de l'utilisateur.
     * @return string : l'adresse email.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Setter pour le mot de passe de l'utilisateur.
     * @param string $password : le mot de passe (hashé ou non).
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Getter pour le mot de passe de l'utilisateur.
     * @return string : le mot de passe hashé.
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Setter pour la photo de profil de l'utilisateur.
     * @param string|null $picture : le chemin ou l'URL de la photo de profil.
     */
    public function setProfilePicture(?string $picture): void
    {
        $this->picture = $picture;
    }

    /**
     * Getter pour la photo de profil de l'utilisateur.
     * @return string|null : le chemin ou l'URL de la photo de profil, ou null si aucune photo.
     */
    public function getProfilePicture(): ?string
    {
        return $this->picture;
    }

    /**
     * Setter pour le slug de l'utilisateur.
     * @param string $slug : le slug (identifiant URL-friendly).
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * Getter pour le slug de l'utilisateur.
     * @return string : le slug (identifiant URL-friendly).
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Setter pour la date de création. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateCreation
     * @param string $format : le format pour la convertion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */
    public function setDateCreation(string|DateTime $dateCreation, string $format = 'Y-m-d H:i:s'): void
    {
        $tz = new DateTimeZone('Europe/Paris');

        if (is_string($dateCreation)) {
            // si les dates en base sont en UTC, préciser UTC à la création
            $dateCreation = DateTime::createFromFormat($format, $dateCreation, new DateTimeZone('UTC')) ?: null;
        }

        if ($dateCreation instanceof DateTime) {
            // convertir l'objet DateTime en Europe/Paris (préserve l'instant)
            $dateCreation->setTimezone($tz);
        }

        $this->dateCreation = $dateCreation;
    }

    /**
     * Récupère la date de création du compte utilisateur.
     * @return DateTime : la date de création.
     */
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    /**
     * Calcule et retourne une chaîne représentant le temps écoulé depuis la création du compte.
     * @return string : une chaîne formatée indiquant l'ancienneté du membre (ex: "Membre depuis 2 ans, 3 mois").
     */
    public function getTimeSinceCreation(): string
    {
        if (!$this->dateCreation instanceof DateTime) {
            return '';
        }

        $now = new DateTime();
        $diff = $now->diff($this->dateCreation);

        $parts = [];

        if ($diff->y > 0) {
            $parts[] = $diff->y . ' ' . ($diff->y > 1 ? 'ans' : 'an');
        }

        if ($diff->m > 0) {
            $parts[] = $diff->m . ' ' . ($diff->m > 1 ? 'mois' : 'mois');
        }

        if ($diff->d > 0) {
            $parts[] = $diff->d . ' ' . ($diff->d > 1 ? 'jours' : 'jour');
        }

        // Si tout est à zéro (inscription aujourd'hui)
        if (empty($parts)) {
            return "aujourd'hui";
        }

        return 'Membre depuis ' . implode(', ', $parts);
    }


}
