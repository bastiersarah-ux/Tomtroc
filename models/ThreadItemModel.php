<?php

/**
 * Classe qui gère les informations d'une conversation.
 */
class ThreadItemModel extends AbstractEntityManager
{
    private int $idThread;
    private string $username;
    private ?string $previewLastMessage;
    private ?DateTime $dateLastMessage;
    private ?string $userPicture;

    public function __construct(array $line)
    {
        $this->idThread = $line['idThread'];
        $this->username = $line['username'];
        $this->previewLastMessage = $line['previewLastMessage'] ?? null;
        $tz = new DateTimeZone('Europe/Paris');
        $this->dateLastMessage = DateTime::createFromFormat('Y-m-d H:i:s', $line['dateLastMessage']) ?? null;
        $this->dateLastMessage?->setTimezone($tz);
        $this->userPicture = $line['userPicture'] ?? null;
    }

    /**
     * Retourne l'identifiant du fil de conversation.
     *
     * @return int L'ID du fil de conversation
     */
    public function getIdThread(): int
    {
        return $this->idThread;
    }

    /**
     * Retourne le pseudo de l'utilisateur.
     *
     * @return string Le pseudo de l'utilisateur
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Retourne l'aperçu du dernier message.
     *
     * @return string|null L'aperçu du dernier message
     */
    public function getPreviewLastMessage(): ?string
    {
        return $this->previewLastMessage;
    }

    /**
     * Retourne la date du dernier message.
     *
     * @return DateTime|null La date du dernier message
     */
    public function getDateLastMessage(): ?DateTime
    {
        return $this->dateLastMessage;
    }

    /**
     * Retourne la photo de profil de l'utilisateur.
     *
     * @return string|null La photo de profil de l'utilisateur
     */
    public function getUserPicture(): ?string
    {
        return $this->userPicture;
    }
}
