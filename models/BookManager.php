<?php

/**
 * Classe qui gère les livres.
 */
class BookManager extends AbstractEntityManager
{
    /**
     * Récupère tous les livres à l'échange.
     * @param string|null $search : recherche par titre.
     * @return array : un tableau d'objets BookExchangeItemModel.
     */
    public function getAllBooks(?string $search): array
    {
        $sql = "SELECT `id`, `title`, `author`, `description`, `status`, `date_creation`, `id_user` FROM book";
        $params = [];

        if (!empty($search)) {
            $sql = $sql . " WHERE title LIKE %:search%";
            $params['search'] = $search;
        }

        $result = $this->db->query($sql, $params);
        $books = [];

        while ($book = $result->fetch()) {
            $books[] = new Book($book);
        }
        return $books;
    }


    /**
     * Récupère les informations d'un livre par son id.
     * @param int $id : l'id de lu livre.
     * @return BookExchangeItemModel|null : un objet BookExchangeItemModel ou null si le livre n'existe pas.
     */
    public function getBookById(int $id): ?Book
    {
        $sql = "SELECT `id`, `title`, `author`, `description`, `status`, `date_creation`, `id_user` FROM book WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $book = $result->fetch();
        if ($book) {
            return new Book($book);
        }
        return null;
    }

    /**
     * Récupère les informations d'un livre par don id + id utilisateur.
     * @param int $id : l'id de lu livre.
     * @param int $id : l'id de l'utilisateur.
     * @return Book|null : un objet Book ou null si le livre n'existe pas.
     */
    public function getBookByIdAndIdUser(int $id, int $idUser): ?Book
    {
        $sql = "SELECT `id`, `title`, `author`, `description`, `status`, `date_creation`, `id_user` FROM book WHERE id = :id AND id_user = :idUser";
        $result = $this->db->query($sql, ['id' => $id, 'idUser' => $idUser]);
        $book = $result->fetch();
        if ($book) {
            return new Book($book);
        }
        return null;
    }

    /**
     * Récupère la bibliothèque de l'utilisateur.
     * @param int $idUser : l'id de l'utilisateur.
     * @return array : un tableau d'objets Book.
     */
    public function getAllBooksbyIdUser(): array
    {
        $sql = "SELECT `id`, `title`, `author`, `description`, `status`, `date_creation`, `id_user` FROM book";
        $result = $this->db->query($sql);
        $books = [];

        while ($book = $result->fetch()) {
            $books[] = new Book($book);
        }
        return $books;
    }
}
