<?php

/**
 * Contrôleur de la partie admin.
 */
class UserController extends AbstractController
{

    /**
     * Affiche la page de compte utilisateur.
     * @return void
     */
    public function showMyAccount(): void
    {
        // On vérifie que l'utilisateur est connecté.
        $this->checkIfUserIsConnected();

        // On récupère l'id de l'utilisateur connecté
        $idUser = $this->getConnectedUserId();

        // On récupère les données de l'utilisateur
        $userManager = new UserManager();
        $user = $userManager->getUserbyId($idUser);

        // On affiche le compte utilisateur.
        $view = new View("Utilisateur");
        $view->render("user", [
            'user' => $user
        ]);
    }
}
