<?php

class BookController extends AbstractController
{
    /**
     * Affiche la page d'accueil avec les 4 derniers livres à l'échange.
     * @param $books : les livres à afficher
     * @return void
     */
    public function showHome(): void
    {

        // Récupère les 4 livres à l'échange les plus récents 
        $bookManager = new BookManager();
        $books = $bookManager->getLastBooks();

        // Envoi à la vue
        $view = new View("Accueil");
        $view->render("home", [
            'books' => $books,
        ]);
    }

    /**
     * Affiche la liste de tous les livres à l'échange avec filtre par titre optionnel via un champ de recherche.
     * @param $books : les livres à afficher
     * @return void
     */
    public function showBooks(): void
    {
        // Récupère le texte de recherche pour filtrer par titre (ou null si le paramètre n'existe pas)
        $search = Utils::request('search');

        // Récupère tous les livres à l'échange. 
        $bookManager = new BookManager();
        $books = $bookManager->getAllBooks($search);

        // Envoi à la vue
        $view = new View("Nos livres à l'échange");
        $view->render("showBooks", [
            'books' => $books
        ]);
    }

    /**
     * Affiche les détails d'un livre spécifique.
     * @param $book : le livre à afficher
     * @param $id : l'id du livre
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

        // On récupère une éventuelle erreur liée à la validation du formulaire
        $errorMessage = $this->getAndClearVariableSession('editBookFormError');

        // Récupère l'id du livre dans la requête
        $idBook = Utils::request('idBook');

        // Détermine si l'on est en création ou modification
        if (empty($idBook)) {
            // Mode création
            $book = null;
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
            'errorMessage' => $errorMessage
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

        // Champs obligatoires
        if (empty($title) || empty($author) || empty($description) || empty($status)) {

            $_SESSION['editBookFormError'] = "Tous les champs sont obligatoires.";

            // On récupère aussi l'id pour renvoyer vers la bonne page (création / modification)
            $idBook = Utils::request('idBook');

            Utils::redirect("editBookForm", ['idBook' => $idBook]);
            return;
        }

        // Récupération de l'id du livre
        $idBook = Utils::request('idBook');

        $bookManager = new BookManager();
        $idUser = $this->getConnectedUserId();

        try {
            // Si pas d'id → création
            if (empty($idBook)) {
                $bookManager->addBook(
                    $title,
                    $author,
                    $description,
                    $status,
                    "",
                    $idUser
                );
            } else {
                // Sinon → mise à jour

                if (!$bookManager->isBookExist($idBook, $idUser)) {
                    $_SESSION['showMyAccountError'] = "Le livre que vous essayer de modifier n'existe pas";
                    Utils::redirect("showMyAccount");
                    return;
                }

                $bookManager->updateBook(
                    $title,
                    $author,
                    $description,
                    $status,
                    ""
                );
            }

            // Si tout est OK, direction Mon compte
            Utils::redirect("myAccount");
            return;
        } catch (Exception $e) {

            // On stocke l’erreur
            $_SESSION['editBookFormError'] = $e->getMessage();

            // On renvoie vers le formulaire, en gardant l'id du livre
            Utils::redirect("editBookForm", ['idBook' => $idBook]);
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
        $idBook = Utils::request('idBook');

        // Si pas d'id → redirection directe (pas de suppression possible)
        if (empty($idBook)) {
            Utils::redirect("myAccount");
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

        // Suppression du livre
        $bookManager->deleteBook($idBook);

        // Redirection vers la page "Mon compte"
        Utils::redirect("myAccount");
    }
}
