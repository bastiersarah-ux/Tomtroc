<?php

/**
 * Classe qui gère les informations d'un message dans une conversation individuel (chat 1-to-1).
 */

class ThreadMessageItemModel extends AbstractEntityManager
{
    private int $idUserTransmitter;
    private string $usernameTransmitter;
    private ?string $content;
    private ?DateTime $dateCreation;
    private ?string $transmitterPicture;

    public function __construct(array $line)
    {
        $this->idUserTransmitter = $line['id_user_transmitter'];
        $this->content = $line['content'];
        $this->usernameTransmitter = $line['username'];
        $tz = new DateTimeZone('Europe/Paris');
        $this->dateCreation = DateTime::createFromFormat('Y-m-d H:i:s', $line['date_creation']) ?? null;
        $this->dateCreation?->setTimezone($tz);
        $this->transmitterPicture = $line['profile_picture'];
    }

    /**
     * Retourne l'identifiant de l'utilisateur qui transmet le message.
     *
     * @return int L'ID de l'utilisateur émetteur
     */
    public function getIdUserTransmitter(): int
    {
        return $this->idUserTransmitter;
    }

    /**
     * Retourne l'identifiant de l'utilisateur qui transmet le message.
     *
     * @return int L'ID de l'utilisateur émetteur
     */
    public function getUsernameTransmitter(): int
    {
        return $this->idUserTransmitter;
    }

    /**
     * Retourne le contenu du message.
     *
     * @return string|null Le contenu du message
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * Retourne la date de création du message.
     *
     * @return DateTime|null La date de création du message
     */
    public function getDateCreation(): ?DateTime
    {
        return $this->dateCreation;
    }

    /**
     * Retourne la photo de profil de l'utilisateur émetteur.
     *
     * @return string|null La photo de profil de l'utilisateur
     */
    public function getTransmitterPicture(): ?string
    {
        return $this->transmitterPicture;
    }
}
