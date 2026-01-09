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
        $sql = "SELECT b.`id`, `title`, `author`, `description`, `status`, b.`date_creation`, `picture`, `id_user`, u.`username`, u.`profile_picture`
            FROM `book` b 
            INNER JOIN user u ON u.id = b.id_user";
        $params = [];

        if (!empty($search)) {
            $sql = $sql . " WHERE title LIKE %:search%";
            $params['search'] = $search;
        }

        $result = $this->db->query($sql, $params);
        $books = [];

        while ($book = $result->fetch()) {
            $books[] = new BookExchangeItemModel($book);
        }
        return $books;
    }


    /**
     * Récupère les informations d'un livre par son id.
     * @param int $id : l'id de lu livre.
     * @return BookExchangeItemModel|null : un objet BookExchangeItemModel ou null si le livre n'existe pas.
     */
    public function getBookById(int $id): ?BookExchangeItemModel
    {
        $sql = "SELECT b.`id`, `title`, `author`, `description`, `status`, b.`date_creation`, `picture`, `id_user`, u.`username`, u.`profile_picture`
            FROM `book` b 
            INNER JOIN user u ON u.id = b.id_user
            WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $book = $result->fetch();
        if ($book) {
            return new BookExchangeItemModel($book);
        }
        return null;
    }

    /**
     * Récupère les informations d'un livre par son id + id utilisateur.
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

    /**
     * Récupère les 4 derniers livres les plus récents parmis tous les livres à l'échange.
     * $sort = colonne par défaut pour trier (la date)
     * $order = sens de tri par défaut (descendant)
     * @param string $sort
     * @param string $order
     * @return array : un tableau d'objets BookExchangeItemModel.
     */
    public function getLastBooks($sort = 'date_creation', $order = 'DESC'): array
    {

        $allowedsort = ['date_creation']; // liste des colonnes autorisées par le tri (sécurité contre injection SQL).
        if (!in_array($sort, $allowedsort)) {
            $sort = 'date_creation';
        }
        $order = 'DESC';
        $sql = "SELECT `date_creation` FROM book ORDER BY $sort $order LIMIT 4";

        $result = $this->db->query($sql);
        $lastBooks = [];

        while ($date = $result->fetch()) {
            $lastBooks[] = new Book($date['date_creation']);
        }

        return $lastBooks;
    }

    /**
     * Ajoute un nouveau livre.
     * @param Book $book : l'objet Book à ajouter.
     * @param $filename : nom du fichier de l'image du livre.
     * @return bool : true si l'ajout a réussi, false sinon.
     */
    public function addBook(Book $book, string $filename): bool
    {
        $sql = "INSERT INTO book (title, description, author, status, date_creation, id_user, picture) VALUES (:title, :description, :author, :status, NOW(), :idUser, :picture)";
        $result = $this->db->query($sql, [
            'title' => $book->getTitle(),
            'description' => $book->getDescription(),
            'author' => $book->getAuthor(),
            'status' => $book->getStatus(),
            'idUser' => $book->getidUser(),
            'picture' => $filename,
        ]);
        return $result->rowCount() > 0;
    }

    /**
     * Modifie un livre.
     * @param Book $book : le livre à modifier.
     * @param $filename : nom du fichier de l'image du livre.
     * @return void
     */
    public function updateBook(Book $book, string $filename): void
    {
        $sql = "UPDATE book SET title = :title, description = :description, author = :author, status = :status, date_creation = NOW(), picture = :picture WHERE id = :id";
        $this->db->query($sql, [
            'title' => $book->getTitle(),
            'description' => $book->getDescription(),
            'author' => $book->getAuthor(),
            'status' => $book->getStatus(),
            'picture' => $filename,
        ]);
    }

    /**
     * Supprime un livre.
     * @param int $id : l'id du livre à supprimmer.
     * @return void
     */
    public function deleteBook(int $id): void
    {
        $sql = "DELETE FROM article WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);
    }
}
