<?php

/**
 * Entité représentant une conversation.
 */
class Thread extends AbstractEntity
{
    private string $userId1 = "";
    private string $userId2 = "";

    /**
     * Setter pour l'id de l'utilisateur 1.
     * @param string $userId1
     */
    public function setUserId1(string $userId1): void
    {
        $this->userId1 = $userId1;
    }

    /**
     * Getter l'id de l'utilisateur 1.
     * @return string $userId1
     */
    public function getUserId1(): string
    {
        return $this->userId1;
    }

    /**
     * Setter pour l'id de l'utilisateur 2.
     * @param string $userId2
     */
    public function setUserId2(string $userId2): void
    {
        $this->userId2 = $userId2;
    }

    /**
     * Getter l'id de l'utilisateur 2.
     * @return string $userId2
     */
    public function getUserId2(): string
    {
        return $this->userId2;
    }
}
