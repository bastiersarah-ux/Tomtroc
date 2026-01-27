<?php

/**
 * Contrôleur de gestion des livres.
 */
class BookController extends AbstractController
{
    /**
     * Affiche la liste de tous les livres disponibles à l'échange avec filtre optionnel par titre.
     * @return void
     */
    public function showBooks(): void
    {
        // Récupère le texte de recherche pour filtrer par titre (ou null si le paramètre n'existe pas)
        $search = Utils::request('search');

        // Récupère tous les livres à l'échange. 
        $bookManager = new BookManager();
        $books = $bookManager->getAllBooks($search, $this->getConnectedUserId());

        // Envoi à la vue
        $view = new View("Nos livres à l'échange");
        $view->render("showBooks", [
            'books' => $books
        ]);
    }

    /**
     * Affiche les détails complets d'un livre spécifique.
     * @return void
     */
    public function showBookDetail(): void
    {
        // Récupère l'id du livre
        $id = Utils::request('id');

        // Si l'id est vide, alors on redirige vers la page 404
        if (empty($id)) {
            Utils::redirect('notFound');
            return;
        }

        // Récupère le détail d'un livre
        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        // Si le livre n'existe pas en BDD, alors on redirige vers la page 404
        if (empty($book)) {
            Utils::redirect('notFound');
            return;
        }

        // Envoi à la vue
        $view = new View($book->getTitle());
        $view->render("showBookDetail", [
            'book' => $book
        ]);
    }

    /**
     * Affiche le formulaire de création ou modification d'un livre.
     * @return void
     */
    public function showBookForm(): void
    {
        // Vérifie que l’utilisateur est connecté
        $this->checkIfUserIsConnected();

        // Récupère l'id du livre dans la requête
        $idBook = Utils::request('id');

        // Détermine si l'on est en création ou modification
        if (empty($idBook)) {
            // Mode création
            $book = new Book();
        } else {
            // Mode modification
            $bookManager = new BookManager();
            $book = $bookManager->getBookByIdAndIdUser($idBook, $this->getConnectedUserId());

            // Si aucun livre correspondant, redirection vers 404
            if ($book === null) {
                Utils::redirect('notFound');
                return;
            }
        }

        // Affiche la page avec le formulaire
        $view = new View("BookForm");
        $view->render("editBookForm", [
            'book' => $book,
            'isEdit' => !empty($book)
        ]);
    }
    /**
     * Ajoute ou met à jour un livre après validation du formulaire.
     * @return void
     */
    public function addOrUpdateBookForm(): void
    {
        // Vérifie que l’utilisateur est connecté
        $this->checkIfUserIsConnected();

        // Récupération des champs du formulaire
        $title = Utils::request('title');
        $author = Utils::request('author');
        $description = Utils::request('description');
        $status = Utils::request('status');
        $picture = $_FILES['picture'];

        // Récupération de l'id du livre
        $idBook = Utils::request('id');
        $idUser = $this->getConnectedUserId();

        // Champs obligatoires
        if (empty($title) || empty($author) || empty($description) || empty($status)) {
            View::sendErrorAlert("Tous les champs sont obligatoires.");
            Utils::redirect("editBookForm");
            return;
        }

        try {
            $bookManager = new BookManager();
            $oldFileName = !empty($idBook)
                ? $bookManager->getCurrentFilename($idBook, $idUser)
                : null;

            $filename = Utils::generateNewFilename($picture, $oldFileName);

            // Si pas d'id → création
            if (empty($idBook)) {
                $bookManager->addBook(
                    $title,
                    $author,
                    $description,
                    $status,
                    $filename,
                    $idUser
                );
            } else {
                // Sinon → mise à jour

                if (!$bookManager->isBookExist($idBook, $idUser)) {
                    View::sendErrorAlert("Le livre que vous essayer de modifier n'existe pas");
                    Utils::redirect("showMyAccount");
                    return;
                }

                $bookManager->updateBook(
                    $idBook,
                    $title,
                    $description,
                    $author,
                    $status,
                    $filename
                );
            }

            // On sauvegarde le fichier s'il est passé dans le formulaire
            Utils::savePicture($picture, $filename, "books");

            if (!empty($oldFileName) && $oldFileName != $filename) {
                Utils::deletePicture($oldFileName, "books");
            }

            // On stocke l’erreur
            View::sendSuccessAlert(empty($idBook) ? "Livre ajouté avec succès" : "Livre modifié avec succès");

            // Si tout est OK, direction Mon compte
            Utils::redirect("showmyaccount");
            return;
        } catch (Exception $e) {

            // On stocke l’erreur
            View::sendErrorAlert($e->getMessage());

            // On renvoie vers le formulaire, en gardant l'id du livre
            Utils::redirect("editBookForm", ['id' => $idBook]);
            return;
        }
    }
    /**
     * Supprime un livre appartenant à l'utilisateur connecté.
     * @return void
     */
    public function deleteBook(): void
    {
        // Vérifie que l’utilisateur est connecté
        $this->checkIfUserIsConnected();

        // Récupère l'id du livre à supprimer
        $idBook = Utils::request('id');

        // Si pas d'id → redirection directe (pas de suppression possible)
        if (empty($idBook)) {
            View::sendErrorAlert("Le livre n'existe pas.");
            Utils::redirect("showmyaccount");
            return;
        }
        // Vérifie que le livre appartient bien à l'utilisateur
        $bookManager = new BookManager();
        $book = $bookManager->getBookByIdAndIdUser($idBook, $this->getConnectedUserId());

        if (empty($book)) {
            // Si le livre n'existe pas ou n'appartient pas à l’utilisateur
            Utils::redirect("notFound");
            return;
        }

        $filename = $book->getPicture();

        try {
            // Suppression du livre
            $bookManager->deleteBook($idBook);
            Utils::deletePicture($filename, "books");
        } catch (Exception $e) {
            View::sendErrorAlert($e->getMessage());
        }

        View::sendSuccessAlert("Livre supprimé avec succès");

        // Redirection vers la page "Mon compte"
        Utils::redirect("showmyaccount");
    }
}
