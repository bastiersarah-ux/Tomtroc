<?php

/**
 * Cette classe génère les vues en fonction de ce que chaque contrôlleur lui passe en paramètre. 
 */
class View
{
    /**
     * Le titre de la page.
     */
    private string $title;

    private string $idPage;

    private const SUCCESS_MESSAGE_KEY = "success";
    private const ERROR_MESSAGE_KEY = "error";

    public static function sendSuccessAlert(string $message)
    {
        $_SESSION[View::SUCCESS_MESSAGE_KEY] = $message;
    }

    public static function sendErrorAlert(string $message)
    {
        $_SESSION[View::ERROR_MESSAGE_KEY] = $message;
    }

    /**
     * Constructeur. 
     */
    public function __construct($title)
    {
        $this->title = $title;
        $this->idPage = strtolower(Utils::request('action', 'home'));
    }

    /**
     * Cette méthode retourne une page complète. 
     * @param string $viewPath : le chemin de la vue demandée par le controlleur. 
     * @param array $params : les paramètres que le controlleur a envoyé à la vue.
     * @return string
     */
    public function render(string $viewName, array $params = []): void
    {
        // On s'occupe de la vue envoyée
        $viewPath = $this->buildViewPath($viewName);

        // Les deux variables ci-dessous sont utilisées dans le "main.php" qui est le template principal.
        $content = $this->_renderViewFromTemplate($viewPath, $params);
        $title = $this->title;
        $idPage = $this->idPage;
        $successMessage = $this->getAndClearSuccessMessage();
        $errorMessage = $this->getAndClearErrorMessage();
        ob_start();
        require(MAIN_VIEW_PATH);
        echo ob_get_clean();
    }

    /**
     * Coeur de la classe, c'est ici qu'est généré ce que le controlleur a demandé. 
     * @param $viewPath : le chemin de la vue demandée par le controlleur.
     * @param array $params : les paramètres que le controlleur a envoyés à la vue.
     * @throws Exception : si la vue n'existe pas.
     * @return string : le contenu de la vue.
     */
    private function _renderViewFromTemplate(string $viewPath, array $params = []): string
    {
        if (file_exists($viewPath)) {
            extract($params); // On transforme les diverses variables stockées dans le tableau "params" en véritables variables qui pourront être lues dans le template.
            ob_start();
            require($viewPath);
            return ob_get_clean();
        } else {
            throw new Exception("La vue '$viewPath' est introuvable.");
        }
    }

    /**
     * Cette méthode construit le chemin vers la vue demandée.
     * @param string $viewName : le nom de la vue demandée.
     * @return string : le chemin vers la vue demandée.
     */
    private function buildViewPath(string $viewName): string
    {
        return TEMPLATE_VIEW_PATH . $viewName . '.php';
    }

    /**
     * Récupère et supprime une variable de la session.
     * @param string $key La clé de la variable à récupérer
     * @return ?string La valeur de la variable ou null si elle n'existe pas
     */
    protected function getAndClearSuccessMessage(): ?string
    {
        if (empty($_SESSION[View::SUCCESS_MESSAGE_KEY])) {
            return null;
        }

        $result = $_SESSION[View::SUCCESS_MESSAGE_KEY];
        unset($_SESSION[View::SUCCESS_MESSAGE_KEY]);

        return $result;
    }

    /**
     * Récupère et supprime une variable de la session.
     * @param string $key La clé de la variable à récupérer
     * @return ?string La valeur de la variable ou null si elle n'existe pas
     */
    protected function getAndClearErrorMessage(): ?string
    {
        if (empty($_SESSION[View::ERROR_MESSAGE_KEY])) {
            return null;
        }

        $result = $_SESSION[View::ERROR_MESSAGE_KEY];
        unset($_SESSION[View::ERROR_MESSAGE_KEY]);

        return $result;
    }
}



