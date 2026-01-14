<?php

abstract class AbstractController
{

    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    protected function checkIfUserIsConnected(): void
    {
        // On vérifie que l'utilisateur est connecté.
        if (empty($_SESSION['idUser'])) {
            Utils::redirect("showConnectionForm");
        }
    }

    /**
     * Récupère l'ID de l'utilisateur connecté.
     * @return ?int
     */
    protected function getConnectedUserId(): ?int
    {
        return $_SESSION['idUser'];
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
