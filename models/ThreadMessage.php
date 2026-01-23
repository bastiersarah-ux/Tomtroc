<?php

/**
 * Entité représentant un message dans une conversation.
 */
class ThreadMessage extends AbstractEntity
{
    private ?DateTime $dateCreation = null;
    private ?DateTime $dateRead = null;
    private string $content = "";
    private string $idUsertransmitter = "";
    private string $idthread = "";

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
     * Récupère la date de création du message.
     * @return DateTime|null : la date de création ou null.
     */
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    /**
     * Setter pour la date de lecture. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateRead : la date de lecture du message.
     * @param string $format : le format pour la conversion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */
    public function setDateRead(string|DateTime $dateRead, string $format = 'Y-m-d H:i:s'): void
    {
        if (is_string($dateRead)) {
            $dateRead = DateTime::createFromFormat($format, $dateRead);
        }
        $this->dateRead = $dateRead;
    }

    /**
     * Récupère la date de lecture du message.
     * @return DateTime|null : la date de lecture ou null si non lu.
     */
    public function getDateRead(): DateTime
    {
        return $this->dateRead;
    }


    /**
     * Setter pour le contenu du message.
     * @param string $content : le contenu textuel du message.
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Getter pour le contenu du message.
     * @return string : le contenu textuel du message.
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Setter pour l'identifiant de l'utilisateur émetteur du message.
     * @param string $transmitterUserId : l'id de l'utilisateur qui a envoyé le message.
     */
    public function setIdUserTransmitter(string $transmitterUserId): void
    {
        $this->idUsertransmitter = $transmitterUserId;
    }

    /**
     * Getter pour l'identifiant de l'utilisateur émetteur du message.
     * @return string : l'id de l'utilisateur qui a envoyé le message.
     */
    public function getIdUserTransmitter(): string
    {
        return $this->idUsertransmitter;
    }

    /**
     * Setter pour l'identifiant de la conversation.
     * @param string $threadId : l'id du thread auquel appartient le message.
     */
    public function SetIdThread(string $threadId): void
    {
        $this->idthread = $threadId;
    }

    /**
     * Getter pour l'identifiant de la conversation.
     * @return string : l'id du thread auquel appartient le message.
     */
    public function GetIdThread(): string
    {
        return $this->idthread;
    }
}
