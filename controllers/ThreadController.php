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

        $idSelected = Utils::request('idThread');


        $threadManager = new ThreadManager();
        $messages = [];

        // if (!empty($idSelected)) {
        //     $messages = $threadManager->getThreadMessagesById($idThread, $idCurrentUser);

        //     // Si le thread n'existe pas encore, on essaie de le créer
        //     if (empty($messages)) {
        //         try {
        //             $threadManager->addThread($idSelected);
        //             // Après ajout, on récupère de nouveau les messages
        //             $messages = $threadManager->getThreadMessagesById($idSelected);
        //         } catch (\Exception $e) {
        //             error_log("Erreur lors de la création du thread : " . $e->getMessage());
        //         }
        //     }
        // }

        // // Récupère la liste de toutes les conversations de l’utilisateur
        // $threads = $threadManager->getAllThreads($this->getConnectedUserId());

        // $this->render('threads', [
        //     'threads' => $threads,
        //     'idSelected' => $idSelected,
        //     'messages' => $messages
        // ]);
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
        $content  = Utils::request('message');

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
}
