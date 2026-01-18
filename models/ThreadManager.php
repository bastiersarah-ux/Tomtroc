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
            u.profile_picture
        FROM thread_message t
        JOIN user u ON t.id_user_transmitter = u.id
        WHERE t.id_thread = ( 
            SELECT id 
            FROM thread 
            WHERE id = :idThread AND :idCurrentUser IN (id_user1, id_user2)
            LIMIT 1
        )
        ORDER BY t.date_creation ASC"; // Trie par ordre chronologique.

        $result = $this->db->query($sql, [
            'idThread' => $idThread,
            'idCurrentUser' => $idCurrentUser
        ]);
        $threads = [];

        while ($line = $result->fetch()) {
            $threads[] = new ThreadMessageItemModel($line);
        }
        return $threads;
    }

    /**
     * Récupère le fil de conversation individuel (chat 1-to-1).
     * @param int $idUser: l'id de l’utilisateur avec qui on créer une conversation.
     * @param int $currentUserId : l'id de l'utilisateur actuellement connecté.
     * @return int $idNewThread: l'id du nouveau thread.
     */
    public function addThread(int $idUser, int $currentIdUser): bool
    {
        $sql = "INSERT INTO thread (user_id1, user_id2) VALUES (:user1, :user2)";

        // Normalisation pour éviter les doublons
        $id1 = min($idUser, $currentIdUser);
        $id2 = max($idUser, $currentIdUser);

        $result = $this->db->query(
            $sql,
            [
                'user1' => $id1,
                'user2' => $id2
            ]
        );
        return $result->rowCount() > 0;
    }


    /**
     * Envoie un message dans la conversation.
     * @param int $idThread : l'id de la conversation.
     * @param int $idUserTransmitter : l'id de l'utilisateur qui envoie un message.
     * @param string $content: le contenu du message.
     * @return int $idNewMessage : l’identifiant du message envoyé.
     */
    public function sendMessage(int $idThread, int $idUserTransmitter, string $content): bool
    {
        $sql = "INSERT INTO thread_message (id_thread, id_user_transmetteur, content, date_creation) VALUES (:idThread, :idUser, :content, NOW())";
        $result = $this->db->query(
            $sql,
            [
                'id_thread' => $idThread,
                'id_user_transmetteur' => $idUserTransmitter,
                'content' => $content
            ]
        );
        return $result->rowCount() > 0;
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
}
