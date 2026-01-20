<?php

/**
 * Classe qui gère la messagerie.
 */
class ThreadManager extends AbstractEntityManager
{
    /**
     * Récupère la liste des conversations.
     * @param int $currentUserId : l'id de l'utilisateur actuellement connecté. 
     * Chaque utilisateur ne doit voir que ses conversations.
     * @return array<ThreadItemModel> : un tableau d'objets ThreadModel.
     */
    public function getAllThreads(int $currentUserId): array
    {
        $sql = "SELECT
            t.id AS idThread,
            t.date_creation,
            u.username,
            u.profile_picture AS userPicture,
            tm.content AS previewLastMessage,
            tm.date_creation AS dateLastMessage
        FROM thread t
        JOIN user u 
            ON u.id = 
                CASE -- Récupère l'utilisateur qui partage la conversation avec l'utilisateur connecté. 
                    WHEN t.id_user1 = $currentUserId THEN t.id_user2 
                    ELSE t.id_user1
                END
        LEFT JOIN thread_message tm 
            ON tm.id = (
                SELECT tm2.id
                FROM thread_message tm2
                WHERE tm2.id_thread = t.id
                ORDER BY tm2.date_creation DESC
                LIMIT 1 ) -- Récupère le message le plus récent de ce thread.
        WHERE $currentUserId IN (t.id_user1, t.id_user2) -- Garde uniquement les conversations de l’utilisateur connecté.
        ORDER BY dateLastMessage DESC"; // Classe la conversation la plus récente en premier.

        $result = $this->db->query($sql);
        $threads = [];

        while ($line = $result->fetch()) {
            $threads[] = new ThreadItemModel($line);
        }

        return $threads;
    }

    /**
     * Récupère le fil de conversation individuel (chat 1-to-1).
     * @param int $idThread : l'id de la conversation.
     * @param int $idCurrentUser : l'id de l'utilisateur connecté.
     * @return array<ThreadMessageItemModel> : un tableau d'objets ThreadMessageItemModel.
     */
    public function getThreadMessagesById(int $idThread, int $idCurrentUser): array
    {
        $sql = "
        SELECT
            t.id_user_transmitter,
            t.content,
            t.date_creation,
            u.profile_picture,
            u.username
        FROM thread_message t
        JOIN user u ON t.id_user_transmitter = u.id
        WHERE t.id_thread = ( 
            SELECT id 
            FROM thread 
            WHERE id = :idThread AND :idCurrentUser IN (id_user1, id_user2)
            LIMIT 1
        )
        ORDER BY t.date_creation DESC"; // Trie par ordre chronologique.

        $result = $this->db->query($sql, [
            'idThread' => $idThread,
            'idCurrentUser' => $idCurrentUser
        ]);
        $threads = [];

        while ($line = $result->fetch()) {
            $threads[] = new ThreadMessageItemModel($line);
        }

        try {
            if (!empty($threads)) {
                $this->markAsRead($idThread, $idCurrentUser);
            }
        } finally {
            return $threads;
        }
    }

    public function getCountNonReadMessage(int $idCurrentUser): int
    {
        // Chaque message compte avec cette requete
        $sql = "SELECT count(1)
                FROM thread_message
                WHERE id_thread IN (
                    SELECT id
                    FROM thread
                    WHERE id_user1 = $idCurrentUser OR id_user2 = $idCurrentUser
                ) AND id_user_transmitter <> $idCurrentUser AND date_read IS NULL
            ";
        // 1 thread avec au moins un message non lu = 1 message non lu (distinct sur le thread)
        // $sql = "SELECT DISTINCT tm.id_thread
        //     FROM thread_message tm
        //     JOIN thread t ON t.id = tm.id_thread
        //     WHERE 
        //         (t.id_user1 = $idCurrentUser OR t.id_user2 = $idCurrentUser)
        //         AND tm.id_user_transmitter <> $idCurrentUser
        //         AND tm.date_read IS NULL";

        $result = $this->db->query($sql);

        return (int)$result->fetchColumn();
    }

    /**
     * Récupère le fil de conversation individuel (chat 1-to-1).
     * @param int $idThread : l'id de la conversation.
     * @return ThreadMessage|null : un tableau d'objets ThreadMessageItemModel.
     */
    public function getThreadMessage(int $idThreadMessage): ?ThreadMessage
    {
        $sql = "SELECT 
                t.id,
                t.id_thread,
                t.date_creation,
                t.content,
                t.id_user_transmitter
            FROM thread_message t 
            WHERE id = ?";

        $result = $this->db->query($sql, [$idThreadMessage]);
        $message = $result->fetch();

        if (empty($message)) {
            return null;
        }

        return new ThreadMessage($message);
    }

    /**
     * Récupère le fil de conversation individuel (chat 1-to-1).
     * @param int $idUser: l'id de l’utilisateur avec qui on créer une conversation.
     * @param int $currentUserId : l'id de l'utilisateur actuellement connecté.
     * @return int $idNewThread: l'id du nouveau thread.
     */
    public function addOrGetThread(int $idUser, int $currentIdUser): int|false
    {
        try {
            $sql = "SELECT id 
                    FROM thread t
                    WHERE $currentIdUser IN (t.id_user1, t.id_user2) 
                        AND $idUser IN (t.id_user1, t.id_user2)";

            $result = $this->db->query($sql);

            if ($result->rowCount() > 0) {
                return (int)$result->fetchColumn();
            }

            $sql = "INSERT INTO thread (id_user1, id_user2) VALUES (?, ?)";

            // Normalisation pour éviter les doublons
            $id1 = min($idUser, $currentIdUser);
            $id2 = max($idUser, $currentIdUser);

            $result = $this->db->query($sql, [$id1, $id2]);
            if ($result->rowCount() == 0) {
                return false;
            }

            return $this->db->getPDO()->lastInsertId();
        } catch (Exception $e) {
            var_dump($e);
            return false;
        }
    }


    /**
     * Envoie un message dans la conversation.
     * @param int $idThread : l'id de la conversation.
     * @param int $idUserTransmitter : l'id de l'utilisateur qui envoie un message.
     * @param string $content: le contenu du message.
     * @return ThreadMessage|null le message envoyé.
     */
    public function sendMessage(int $idThread, int $idUserTransmitter, string $content): ThreadMessage|false
    {
        $sql = "INSERT INTO thread_message (id_thread, id_user_transmitter, content, date_creation) VALUES (:idThread, :idUser, :content, NOW())";
        $result = $this->db->query(
            $sql,
            [
                'idThread' => $idThread,
                'idUser' => $idUserTransmitter,
                'content' => $content
            ]
        );

        if ($result->rowCount() == 0) {
            return false;
        }

        $idMessage = $this->db->getPDO()->lastInsertId();

        return $this->getThreadMessage($idMessage);
    }

    /**
     * Récupère le thread unique entre deux utilisateurs.
     * @param int $idUser1 : id du premier utilisateur.
     * @param int $idUser2 : id du deuxième utilisateur.
     * @return int|null : idThread du thread, ou null si aucun thread existant.
     */
    public function getThreadByUsers(int $idUser1, int $idUser2): ?int
    {
        // Normalisation pour éviter les doublons
        $id1 = min($idUser1, $idUser2);
        $id2 = max($idUser1, $idUser2);

        $sql = "SELECT idThread FROM threads  WHERE id_user1 = :id1 AND id_user2 = :id2  LIMIT 1";

        $result = $this->db->query(
            $sql,
            ['id1' => $id1, 'id2' => $id2]
        );

        return $result['idThread'] ?? null;
    }

    private function markAsRead(int $idThread, int $idUser): bool
    {
        try {
            $sql = "UPDATE thread_message 
                SET date_read = CURRENT_TIMESTAMP()
                WHERE id_thread = ? AND id_user_transmitter <> ?";

            $this->db->query($sql, [$idThread, $idUser]);
            return true;
        } catch (Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
    }
}
