<?php

class CoreController extends AbstractController
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
}
