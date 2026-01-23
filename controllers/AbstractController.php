<?php

abstract class AbstractController
{

    /**
     * Vérifie que l'utilisateur est connecté et redirige vers la page de connexion sinon.
     * @return void
     */
    protected function checkIfUserIsConnected(): void
    {
        // On vérifie que l'utilisateur est connecté.
        if (!Utils::hasUserConnected()) {
            Utils::redirect("showConnectionForm");
        }
    }

    /**
     * Récupère l'identifiant de l'utilisateur actuellement connecté.
     * @return int|null : l'ID de l'utilisateur connecté ou null.
     */
    protected function getConnectedUserId(): ?int
    {
        return Utils::getCurrentIdUser();
    }

    /**
     * Récupère et supprime une variable de la session.
     * @param string $key La clé de la variable à récupérer
     * @return ?string La valeur de la variable ou null si elle n'existe pas
     */
    protected function getAndClearVariableSession(string $key): ?string
    {
        if (empty($_SESSION[$key])) {
            return null;
        }

        $result = $_SESSION[$key];
        unset($_SESSION[$key]);

        return $result;
    }
}
