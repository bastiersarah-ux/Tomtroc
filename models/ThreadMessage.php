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
     * Récupère la date de création.
     *
     * @return DateTime|null
     */
    public function getDateCreation(): DateTime
    {
        return $this->dateCreation;
    }

    /**
     * Setter pour la date de création. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $dateCreation
     * @param string $format : le format pour la convertion de la date si elle est une string.
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
     * Récupère la date de création.
     *
     * @return DateTime|null
     */
    public function getDateRead(): DateTime
    {
        return $this->dateRead;
    }


    /**
     * Setter pour le contenu du message.
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Getter pour le contenu du message.
     * @return string $content
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Setter pour le transmetteur du message.
     * @param string $transmitterUserId
     */
    public function setIdUserTransmitter(string $transmitterUserId): void
    {
        $this->idUsertransmitter = $transmitterUserId;
    }

    /**
     * Getter pour le transmetteur du message.
     * @return string $transmitterUserId
     */
    public function getIdUserTransmitter(): string
    {
        return $this->idUsertransmitter;
    }

    /**
     * Setter pour l'id de la conversation.
     * @param string $threadId
     */
    public function SetIdThread(string $threadId): void
    {
        $this->idthread = $threadId;
    }

    /**
     * Getter pour l'id de la conversation.
     * @return string $threadId
     */
    public function GetIdThread(): string
    {
        return $this->idthread;
    }
}
