<?php

/**
 * Entité représentant un message dans une conversation.
 */
class ThreadMessage extends AbstractEntity
{
    private ?DateTime $dateCreation = null;
    private string $content = "";
    private string $transmitterUserId = "";
    private string $threadId = "";

    /**
     * Setter pour la date de création du message.
     * @param DateTime $dateCreation : 
     * @return DateTime
     */
    public function setDateCreation(DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    /**
     * Getter pour la date de création du message.
     * @return DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
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
    public function setTransmitterUserId(string $transmitterUserId): void
    {
        $this->transmitterUserId = $transmitterUserId;
    }

    /**
     * Getter pour le transmetteur du message.
     * @return string $transmitterUserId
     */
    public function getTransmitterUserId(): string
    {
        return $this->transmitterUserId;
    }

    /**
     * Setter pour l'id de la conversation.
     * @param string $threadId
     */
    public function SetThreadId(string $threadId): void
    {
        $this->threadId = $threadId;
    }

    /**
     * Getter pour l'id de la conversation.
     * @return string $threadId
     */
    public function GetThreadId(): string
    {
        return $this->threadId;
    }
}
