<?php

/**
 * Contrôleur de la partie messagerie.
 */
class ThreadController extends AbstractController
{

    /**
     * Affiche la liste des conversations de l'utilisateur connecté.
     * Récupère également les messages d'une conversation si un thread est sélectionné.
     */
    public function showThreads(): void
    {
        $this->checkIfUserIsConnected();

        $idSelected = Utils::request('id');
        $idUser = $this->getConnectedUserId();

        $threadManager = new ThreadManager();
        $messages = [];

        $threads = $threadManager->getAllThreads($idUser);
        $currentThread = null;

        if (!empty($idSelected)) {
            $messages = $threadManager->getThreadMessagesById($idSelected, $idUser);

            // On vérifie que l'id passé en paramètre corresponds à une discussion de l'utilisateur

            $currentThread = $this->findThreadById($threads, $idSelected);
        }


        $view = new View("Messagerie");
        $view->render("thread", [
            'threads' => $threads,
            '$messages' => $messages,
            'current' => $currentThread
        ]);
    }

    /**
     * Crée une nouvelle conversation entre l'utilisateur connecté et un autre utilisateur.
     */
    public function createThread(): void
    {
        $this->checkIfUserIsConnected();

        // Récupère l'id du contact avec lequel on veut créer la conversation
        $idThread = Utils::request('idThread');

        if (empty($idThread)) {
            Utils::redirect("threads");
            return;
        }

        // Création du thread 
        $threadManager = new ThreadManager();

        try {
            // Création du thread entre user connecté et l’autre user ($idThread)
            // $threadManager->addThread($idThread);
        } catch (\Exception $e) {
            error_log("Erreur création thread : " . $e->getMessage());
            // Redirige vers la liste
            Utils::redirect("threads");
            return;
        }

        Utils::redirect("threads", ['id' => $idThread]);
    }

    /**
     * Envoie un message dans une conversation existante.
     */
    public function sendMessage(): void
    {
        $this->checkIfUserIsConnected();

        // Récupère l'id du thread et le contenu du message
        $idThread = Utils::request('idThread');
        $content = Utils::request('message');

        // Paramètres obligatoires (un thread + un message)
        if (empty($idThread) || empty($content)) {
            Utils::redirect("threads");
            return;
        }

        // Création du thread
        $threadManager = new ThreadManager();

        try {
            // Enregistre le message en BDD
            $threadManager->sendMessage($idThread, $this->getConnectedUserId(), $content);
        } catch (\Exception $e) {
            error_log("Erreur lors de l'envoi du message : " . $e->getMessage());
        }

        Utils::redirect("threads", ['id' => $idThread]);
    }

    private function findThreadById(array $items, int $id): ?ThreadItemModel
    {
        foreach ($items as $element) {
            if ($id == $element->getIdThread()) {
                return $element;
            }
        }

        return null;
    }
}
