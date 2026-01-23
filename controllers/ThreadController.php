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
            'messages' => $messages,
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
        $slug = Utils::request('user');

        if (empty($slug)) {
            Utils::redirect("showthreads");
            return;
        }

        $userManager = new UserManager();
        $user = $userManager->getUserBySlug($slug);



        if (empty($user)) {
            Utils::redirect("showthreads");
            return;
        }

        // Création du thread 
        $threadManager = new ThreadManager();

        try {
            // Création du thread entre user connecté et l’autre user ($idThread)
            $idThread = $threadManager->addOrGetThread($user->getId(), $this->getConnectedUserId());
            Utils::redirect("showthreads", ['id' => $idThread]);
        } catch (\Exception $e) {
            error_log("Erreur création thread : " . $e->getMessage());
            // Redirige vers la liste
            Utils::redirect("showthreads");
            return;
        }
    }

    /**
     * Envoie un message dans une conversation existante.
     */
    public function sendMessage(): void
    {
        if (!Utils::hasUserConnected()) {
            $this->sendJsonResponse(null, 401);
        }

        // Récupère l'id du thread et le contenu du message
        $idThread = Utils::request('idThread');
        $content = Utils::request('message');

        // Paramètres obligatoires (un thread + un message)
        if (empty($idThread) || empty($content)) {
            $this->sendJsonResponse(null, 401);
            return;
        }

        // Création du thread
        $threadManager = new ThreadManager();

        try {
            // Enregistre le message en BDD
            $message = $threadManager->sendMessage($idThread, $this->getConnectedUserId(), $content);
            if (!$message) {
                $this->sendJsonResponse(null, 500);
                return;
            }

            $response = (object) [
                'fullDate' => Utils::formatMessageDateTime($message->getDateCreation()),
                'shortDate' => Utils::formatCompactDate($message->getDateCreation()),
                'timestamp' => $message->getDateCreation()->getTimestamp()
            ];

            $this->sendJsonResponse($response);
        } catch (\Exception $e) {
            // error_log("Erreur lors de l'envoi du message : " . $e->getMessage());
            $this->sendJsonResponse($e->getMessage(), 500);
        }
    }

    /**
     * Retourne le nombre de messages non lus pour l'utilisateur connecté (requête AJAX).
     * @return void
     */
    public function countNonReadMessage()
    {
        if (!Utils::hasUserConnected()) {
            $this->sendJsonResponse(null, 401);
            return;
        }

        try {
            // Création du thread
            $threadManager = new ThreadManager();
            $count = $threadManager->getCountNonReadMessage($this->getConnectedUserId());

            $this->sendJsonResponse($count);
        } catch (Exception $e) {
            $this->sendJsonResponse($e->getMessage(), 500);
        }
    }

    /**
     * Envoie une réponse JSON avec le code HTTP spécifié.
     * @param mixed $data : les données à encoder en JSON.
     * @param int $responseCode : le code de réponse HTTP (200 par défaut).
     * @return void
     */
    private function sendJsonResponse(mixed $data, int $responseCode = 200): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($responseCode);
        echo json_encode($data);
    }

    /**
     * Recherche une conversation spécifique dans un tableau par son identifiant.
     * @param array $items : le tableau de conversations.
     * @param int $id : l'identifiant de la conversation recherchée.
     * @return ThreadItemModel|null : la conversation trouvée ou null.
     */
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
