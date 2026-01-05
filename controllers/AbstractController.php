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
        if (empty($_SESSION['userId'])) {
            Utils::redirect("connectionForm");
        }
    }

    protected function getConnectedUserId(): ?int
    {
        return $_SESSION['userId'];
    }
}
